<?php
ob_start();
include "./includes/templates/header.php";
include "./includes/func/functions.php";
include "connect.php";

include "./includes/func/Parsedown.php";

if (isset($_GET["cat"]) && $_GET['do'] == 'show') {
    $stmt = $con->prepare("select * from events ev join users u on ev.author = u.id join categor ca on ca.id_category = ev.id_category   where ca.name = ?");
    $stmt->execute([$_GET["cat"]]);
    $data = $stmt->fetchAll();
?>

    <section class="events">
        <div class="container">
            <h1>Events</h1>
            <div class="row">
                <?php
                foreach ($data as $event) {
                ?>
                    <div class="col-sm-3">
                        <div class="event">
                            <div class="over">

                                <p class="text-center"><?php echo $event['title'] ?></p>
                                <a class="showBtn btn btn-info" href="event_show.php?do=showDatails&eventID=<?php echo $event["id_event"] ?>">More details +</a>
                            </div>
                            <div class="img-container">
                                <img src='layout/images/<?php echo $event['image'] ?>'>
                            </div>
                            <ul class="info-event list-unstyled">
                                <li> <strong> category : <?php echo $event['name'] ?></strong></li>
                                <li class="author">created by <?php echo $event['nickname'] ?> </li>
                                <li class="date-event"> <?php echo formatDate($event['date_debut']) ?> </li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </section>


<?php } else {
    $stmt = $con->prepare("select * from events ev join users u on ev.author = u.id join categor ca on ca.id_category = ev.id_category where ev.id_event = ?");
    $stmt->execute([$_GET["eventID"]]);
    $data = $stmt->fetch();

?>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="img-container img-event">
                    <img src='layout/images/<?php echo $data['image'] ?>'>

                </div>
            </div>
            <div class="col-md-6">
                <div class="eventInfo information">
                    <h2><?php echo $data["title"] ?></h2>
                    <ul class="list-unstyled">
                        <li> <i class="fas fa-info-circle"></i> <span>Description: </span><br> <?php echo $data["description"] ?> </li>
                        <li> <i class="fas fa-calendar-alt"></i> <span>Date: </span><?php echo  $data["date_debut"] ?></li>
                        <li><i class="fas fa-tags"></i> <span>Category: </span><?php echo  $data["name"] ?></li>
                        <li><i class="fas fa-user"></i> <span>Created by: </span><?php echo  $data["nickname"] ?></li>

                        <?php
                        $participantsverification = $con->prepare('SELECT * FROM association WHERE participate_eventid = ?');
                        $participantsverification->execute(array($_GET['eventID']));
                        $participants = $participantsverification->rowCount(); ?>

                        <li><i class="fas fa-users"></i><span>Participants : </span><?php echo $participants ?></li>
                    </ul>

                    <?php

                    $participationverification = $con->prepare('SELECT * FROM association WHERE participate_userid = ? && participate_eventid = ?');
                    $participationverification->execute(array($_SESSION['userid'], $_GET['eventID']));
                    $participation = $participationverification->rowCount();


                    if ($data['date_debut'] <= date("Y-m-d H:i:s")) {
                     if ($participation == 1) { ?>
                        <a href="" class="btn btn-block btn-primary">You Participated</a>
                     <?php } else {?>
                        <a href="" class="btn btn-block btn-danger">You did not participate</a>
                     <?php } ?>
                    <?php } else {

                        if ($participation == 1) { ?>
                        <a href="event_participate.php?cancel_userid=<?php echo $_SESSION['userid']; ?>&cancel_eventid=<?php echo $_GET['eventID']; ?>" class="btn btn-block btn-danger">Cancel Participation</a>
                        <?php } else if (isset($_SESSION['userid'])) {?>
                            <a href="event_participate.php?participate_userid=<?php echo $_SESSION['userid']; ?>&participate_eventid=<?php echo $_GET['eventID']; ?>" class="btn btn-block btn-primary">Register Participation</a>
                            <?php } else { ?>
                                <a href="login.php" class="btn btn-block btn-primary">Login required to Register</a>
                            <?php } 
                    }?>

              
                </div>
            </div>
        </div>
        <hr class="custom-hr">
        <?php


        if (!empty($_SESSION)) { ?>

            <div class="row">
                <div class="col-md-offset-3">
                    <div class="add-comment">
                        <h3>Add your comment</h3>

                        <form method='POST' action="<?php echo $_SERVER["PHP_SELF"] . '?eventID=' . $data["id_event"] ?>">
                            <textarea class="form-control" name="comment"></textarea>
                            <input class="btn btn-primary" type="submit"></input>
                        </form>

                    </div>
                </div>
            </div>
        <?php

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $comment = $_POST['comment'];

                if (!empty($comment)) {
                    $stmt = $con->prepare('INSERT INTO comments(event_id ,`user_id` ,comment) VALUE(?,?,?)');
                    $stmt->execute([$_GET['eventID'], $_SESSION['userid'], $comment]);
                    $comment = "";
                    header("location:event_show.php?eventID=" . $data["id_event"] . "");
                }
            }
        } else {
            echo " <p><a href='login.php'>Login or sighup</a> to make a comment</p>";
        } ?>
        <hr class="custom-hr">



        <?php

        $stmt = $con->prepare('SELECT co.comment , us.nickname FROM comments co join users us on us.id = co.user_id WHERE co.event_id = ?');
        $stmt->execute([$_GET['eventID']]);
        $comments = $stmt->fetchAll();
        $row = $stmt->rowCount();

        if ($row <= 0) {
            echo "This event no cntains commentaire";
        } else {

            foreach ($comments as $comment) { ?>

                <div class="comment-box">
                    <div class="row">
                        <div class="col-md-2">

                            <img src='layout/images/<?php echo $event['image'] ?>'>
                            <strong class="text-center"><?php echo $comment["nickname"] ?></strong>
                        </div>
                        <div class="col-md-10">
                            <p class="lead"><?php echo $comment['comment'] ?></p>
                        </div>
                    </div>
                    <hr class="custom-hr">
                </div>


        <?php

            }
        }
        ?>

    </div>

<?php } ?>


<?php
include "./includes/templates/footer.php";
ob_end_flush();

?>