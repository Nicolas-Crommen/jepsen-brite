<?php
include "./includes/templates/header.php";
?>

<div class="container login-page">
    <h1 class="text-center"><span class="login-btn">Login</span> | <span class="singup-btn">Singup</span></h1>
    <form action="" class="login" id="login">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Your user name" />
        <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Your password" />
        <input class="btn btn-primary btn-block" type="submit" value="Login" />
    </form>


    <!--Form sign up-->

    <form action="" class="signup" id="singup">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Your user name" />
        <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Your password" />
        <input class="form-control" type="password-again" name="second-password" autocomplete="new-password" placeholder="Your password" />
        <input class="form-control" type="email" name="email" autocomplete="new-password" placeholder="Type a Valid email" />
        <input class="btn btn-success btn-block" type="submit" value="signup" />
    </form>
</div>


<?php
include "./includes/templates/footer.php";
?>