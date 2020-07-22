<?php
include "./includes/templates/header.php";
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userName = $_POST["username"];
    $pass =  $_POST["password"];
    $secPass =  $_POST["second-password"];
    $email = $_POST["email"];
    $errorsForm = array();

    if (strlen($userName) <= 2) {
        $errorsForm[] = "<div class='alert alert-danger text-center'>user name must be larger than 2 char </div>";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $errorsForm[] =   "<div class='alert alert-danger text-center'>not valid email </div>";
    }

    if (empty($pass) || strlen($pass > 5)) {
        $errorsForm[] = "<div class='alert alert-danger text-center'> password must be larger than 5 , must contain charachters </div>";
    }


    if ($pass != $secPass) {
        $errorsForm[] = "<div class='alert alert-danger text-center'>Password not Mathc</div>";
    }



    /*is l'array d'erreurs est vide on va inserer le user dans la BD*/
    if (sizeof($errorsForm) == 0) {

        $query = $con->prepare("SELECT nickname FROM users WHERE nickname = ?");
        $query->execute([$userName]);
        $row = $query->rowCount();
        if ($row > 0) {
            echo "Sorry this user is already exist";
        } else {
            $query = $con->prepare("INSERT INTO  users(email , nickname ,password ,avatar) value (? ,? ,? ,?)");
            $query->execute([$email, $userName, sha1($pass), "test"]);
            header("location:index.php");
        }
        /*Sinon on affiche les erreurs*/
    } else {

        foreach ($errorsForm as $error) {
            echo $error;
        }
    }
}




?>

<div class="container login-page">
    <h1 class="text-center"><span class="login-btn">Login</span> | <span class="singup-btn">Singup</span></h1>
    <form action=<?php echo $_SERVER["PHP_SELF"] ?> class="login" id="login" method="">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Your user name" />
        <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Your password" />
        <input class="btn btn-primary btn-block" type="submit" value="Login" />
    </form>


    <!--Form sign up-->
    <form action=<?php echo $_SERVER["PHP_SELF"] ?> class="signup" id="singup" method="POST">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Your user name" />
        <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Your password" />
        <input class="form-control" type="password" name="second-password" autocomplete="new-password" placeholder="Passwors again" />
        <input class="form-control" type="email" name="email" autocomplete="new-password" placeholder="Type a Valid email" />
        <input class="btn btn-success btn-block" type="submit" value="signup" />
    </form>
</div>


<?php
include "./includes/templates/footer.php";
?>