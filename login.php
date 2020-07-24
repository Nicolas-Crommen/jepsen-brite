<?php
include "./includes/templates/header.php";
include "connect.php";
include "./includes/func/functions.php";

if (isset($_SESSION['userid'])) {
    header("location:index.php");
    exit();
}

/* Start Sign Up */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $userName = $_POST["username"];
    $pass =  $_POST["password"];
    $secPass =  $_POST["second-password"];
    $email = $_POST["email"];
    $errorsForm = array();

    if (isset($userName) && strlen($userName) <= 2) {
        $errorsForm[] = "<div class='alert alert-danger text-center'>user name must be larger than 2 char </div>";
    }
    if (isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $errorsForm[] =   "<div class='alert alert-danger text-center'>not valid email </div>";
    }

    if (strlen($pass >= 5)) {
        $errorsForm[] = "<div class='alert alert-danger text-center'> password must be larger than 5 , must contain charachters </div>";
    }


    if (isset($secPass) && $pass != $secPass) {
        $errorsForm[] = "<div class='alert alert-danger text-center'>Password not Mathc</div>";
    }

    /*is l'array d'erreurs est vide on va inserer le user dans la BD*/
    if (sizeof($errorsForm) == 0 && isset($errorsForm)) {
        /*isExist est une function qui verifie si un element existe dans la base de donnée si l'element est
           edist ca renvoie 1 au sinon ca renvoi 0 (La function est dans le ficher includes/functions) */
        if (isExist('nickname', 'users', $userName)) {

            echo isExist('nickname', 'users', $userName);
            echo "<div class='alert alert-danger text-center'>Sorry this user is already exist</div>";
        } else {
            $query = $con->prepare("INSERT INTO  users(email , nickname ,password ,avatar ,registre_date) value (? ,? ,? ,?,now())");
            $query->execute([$email, $userName, password_hash($pass, PASSWORD_DEFAULT), "test"]);
            echo ($query->rowCount());
            echo "<div class='alert alert-success text-center'> Your account has been successfully created </div>";
            header("refresh: 2; url = login.php");
            exit();
        }
        /*Sinon on affiche les erreurs*/
    } else {

        foreach ($errorsForm as $error) {
            echo $error;
        }
    }
}
/* End Sign Up */

/*Start login*/
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $userName = $_POST["user"];
    $pass = $_POST["pass"];


    $stmt = $con->prepare('SELECT id, nickname , password FROM users WHERE nickname=?');
    $stmt->execute([$userName]);
    $row = $stmt->rowCount();
    $data = $stmt->fetch();

    if ($row > 0 && password_verify($_POST["pass"], $data['password'])) {
        $_SESSION['userid'] = $data['id'];
        $_SESSION['nickname'] = $data['nickname'];
        echo '<div class="alert alert-success text-center">Authentification validée</div>';
        header("refresh: 2; url = index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger text-center'>this account doesn't exist</div>";
        header("refresh: 2; url = login.php");
        exit();
    }
}

/*End login*/

?>
<div class="container login-page">
    <h1 class="text-center"><span class="login-btn">Login</span> | <span class="singup-btn">Signup</span></h1>
    <form action=<?php echo $_SERVER["PHP_SELF"] ?> class="login" id="login" method="POST">
        <input class="form-control" type="text" name="user" autocomplete="off" placeholder="Your user name" required="required" />
        <div class="form-group password">
            <i class="fas fa-eye-slash"></i>
            <input class="form-control pass-login" type="password" name="pass" autocomplete="new-password" placeholder="Your password" required="required">
        </div>

        <input class="btn btn-primary btn-block" type="submit" value="Login" name="login" />
    </form>


    <!--Form sign up-->
    <form action=<?php echo $_SERVER["PHP_SELF"] ?> class="signup" id="singup" method="POST">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Your user name" required="required" />
        <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Your password" required="required" />
        <input class="form-control" type="password" name="second-password" autocomplete="new-password" placeholder="Passwors again" required="required" />
        <input class="form-control" type="text" name="email" autocomplete="new-password" placeholder="Type a Valid email" required="required" />
        <input class="btn btn-success btn-block" type="submit" value="signup" name="signup" />
    </form>
</div>


<?php
include "./includes/templates/footer.php";
?>