<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="./layout/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <title>Document</title>
</head>

<body>

    <div class="upper-bar">
        <div class="container">

            <?php if (isset($_SESSION['userid'])) { ?>
                <a href="logout.php"><span class="pull-right">Logout</span></a>
            <?php } else { ?>
                <a href="login.php"><span class="pull-right">Login/Sign-up</span></a>
            <?php } ?>

        </div>
    </div>

    <nav class="navbar navbar-inverse">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Jepsen Brite</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">

                    <li><a href="index.php">Home</a></li>
                    <?php if (isset($_SESSION['userid'])) { ?>
                        <li><a class="profile-link" href="user_events.php">My events</a></li>
                    <?php } ?>
                    <?php if (isset($_SESSION['userid'])) { ?>
                        <li><a class="profile-link" href="event_form.php">Add my event</a></li>
                    <?php } ?>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <?php if (isset($_SESSION['userid'])) { ?>
                        <li><a class="profile-link" href="profile.php"><?php echo strtoupper($_SESSION["nickname"])  ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>