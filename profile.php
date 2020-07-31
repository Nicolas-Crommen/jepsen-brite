<?php
include "./includes/templates/header.php";
include "connect.php";

if (!empty($_SESSION) && empty($_GET['do'])) {

    $stmt = $con->prepare('SELECT id , nickname , email , registre_date  FROM users where id = ? and nickname = ? ');
    $stmt->execute([$_SESSION['userid'], $_SESSION['nickname']]);
    $row = $stmt->fetch();

    if (isset($_SESSION['userid'])) { ?>
        <div class="container">
            <h1 class="text-center">My profile</h1>
            <div class="panel panel-primary information">
                <div class="panel-heading">
                    <h6 class="text-center">MY INFO</h6>
                    <div class="img-profile">
                        <img src="https://via.placeholder.com/100.png/09f/fffC/O https://placeholder.com/">
                    </div>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li><i class="fas fa-sign-in-alt"></i> <span> login name: </span> <?php echo $row["nickname"] ?></li>
                        <li> <i class="far fa-envelope"></i> <span>Email: </span> <?php echo $row["email"] ?> </li>
                        <li><i class="fas fa-calendar"></i> <span>Date registre: </span><?php echo $row["registre_date"] ?></li>
                    </ul>
                </div>
            </div>
            <a href="profile.php?do=edit&Userid=<?php echo $_SESSION['userid'] ?>" class=" btn btn-primary">Edit</a>
            <a href="profile.php?do=delete" class="btn btn-danger" id="btnDelete">Delete your account</a>
        </div>

    <?php }
} elseif (!empty($_SESSION) && $_GET['do'] == "edit" && $_GET["Userid"] == $_SESSION["userid"]) {

    $stmt = $con->prepare('SELECT id , nickname , email  FROM users where id = ? and nickname = ? ');
    $stmt->execute([$_SESSION['userid'], $_SESSION['nickname']]);
    $row = $stmt->fetch(); ?>

    <div class="container edit">
        <h2 class="text-center">Edit Yor Profile</h2>
        <form class="form-edit" action="?do=update" method="POST">
            <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Your user name" required="required" value=<?php echo $row['nickname'] ?> />
            <input class="form-control" type="text" name="email" autocomplete="new-password" placeholder="Type a Valid email" required="required" value=<?php echo $row['email'] ?> />
            <input class="btn btn-success btn-block" type="submit" value="update" name="update" />
        </form>
    </div>
<?php



} elseif (!empty($_SESSION) && $_GET["do"] == "update") {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $con->prepare("UPDATE users SET nickname = ? , Email = ?  WHERE id =?");
        $stmt->execute([$_POST["username"], $_POST["email"], $_SESSION['userid']]);
        $_SESSION["nickname"] = $_POST["username"];

        if ($stmt->rowCount() > 0) {
            echo "<div class='alert alert-success text-center'>Your personal information has been successfully updated</div>";
            header("refresh: 2; url = profile.php");
            exit();
        }
    }
} elseif (!empty($_SESSION) && $_GET["do"] == "delete") {
    $stmt = $con->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['userid']]);

    if ($stmt->rowCount() > 0) {
        echo "<div class='alert alert-success text-center'>Your account has been successfully deleted</div>";
        header("refresh: 2; url = logout.php");
        exit();
    }
} else {
    echo "<div class='alert alert-danger text-center'>Sorry you don't have access to this page</div>";
}



?>



<?php include "./includes/templates/footer.php"; ?>