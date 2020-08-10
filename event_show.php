<?php
ob_start();
include "./includes/templates/header.php";
include "./includes/func/functions.php";
include "connect.php";

/*Afficher les events en fonction de catégroie (dropDownMenu)*/
if (isset($_GET["cat"]) && $_GET['do'] == 'showByCat') {
    $stmt = $con->prepare("select * from events ev join users u on ev.author = u.id join categor ca on ca.id_category = ev.id_category  where ca.name = ?");
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
                                <a class="showBtn btn btn-info" href="event_show.php?eventID=<?php echo $event["id_event"] ?>">More details +</a>
                            </div>

                            <div class="img-container">
                                <img src="$event['image'] ?>">
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



<?php } elseif (isset($_GET) && isset($_GET["eventID"])) {
    /*Afficher detailis lorqu'on click sur le buton --More details--*/
    $stmt = $con->prepare("SELECT * from events e join categor c on e.id_category = c.id_category join categor sup on sup.id_category = e.id_sub join users us on us.id = e.author where e.id_event = ?");
    $stmt->execute([$_GET["eventID"]]);
    $data = $stmt->fetch();

?>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="img-container img-event">
                    <?php if ($data['image_type'] == 1) {
                        echo '<img src="' . $data['image'] . '">';
                    } elseif ($data['image_type'] == 2) {
                        echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $data['image'] . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    } else {
                        echo '<iframe src="https://player.vimeo.com/video/' . $data['image'] . '" width="560" height="315" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
                    }
                    ?>

                </div>
            </div>
            <div class="col-md-6">

                <div class="eventInfo information">
                    <h2><?php echo $data["title"] ?></h2>
                    <ul class="list-unstyled">
                        <li> <i class="fas fa-info-circle"></i> <span>Description: </span><br> <?php echo $data["description"] ?> </li>
                        <li> <i class="fas fa-calendar-alt"></i> <span>Date: </span><?php echo  $data["date_debut"] ?></li>
                        <li><i class="fas fa-tags"></i> <span>Category: </span><?php echo  $data["13"] ?></li>
                        <li><i class="fas fa-tags"></i> <span>Sub Category: </span><?php echo  $data["name"] ?></li>
                        <li> <i class="fas fa-map-marker"></i> <span>Place: </span><?php echo $data["address"] ?></li>
                        <li><i class="fas fa-user"></i> <span>Created by: </span><?php echo  $data["nickname"] ?></li>
                        <?php
                        $participantsverification = $con->prepare('SELECT * FROM association WHERE participate_eventid = ?');
                        $participantsverification->execute(array($_GET['eventID']));
                        $participants = $participantsverification->rowCount(); ?>

                        <li><i class="fas fa-users"></i><span>Participants : </span><?php echo $participants ?></li>



                        <?php

                        $participationverification = $con->prepare('SELECT * FROM association WHERE participate_userid = ? && participate_eventid = ?');
                        $participationverification->execute(array($_SESSION['userid'], $_GET['eventID']));
                        $participation = $participationverification->rowCount();


                        if ($data['date_debut'] <= date("Y-m-d H:i:s")) {
                            if ($participation == 1) { ?>
                                <button disabled href="" class="btn btn-block btn-primary">You Participated</button>
                            <?php } else { ?>
                                <button disabled href="" class="btn btn-block btn-danger">You did not participate</button>
                            <?php } ?>
                            <?php } else {

                            if ($participation == 1) { ?>
                                <a href="event_participate.php?cancel_userid=<?php echo $_SESSION['userid']; ?>&cancel_eventid=<?php echo $_GET['eventID']; ?>" class="btn btn-block btn-danger">Cancel Participation</a>
                            <?php } else if (isset($_SESSION['userid'])) { ?>
                                <a href="event_participate.php?participate_userid=<?php echo $_SESSION['userid']; ?>&participate_eventid=<?php echo $_GET['eventID']; ?>" class="btn btn-block btn-primary">Register Participation</a>
                            <?php } else { ?>
                                <a href="login.php" class="btn btn-block btn-primary">Login required to Register</a>
                        <?php }
                        } ?>
                        <li><iframe src="https://www.google.com/maps?q=<?php echo $data["address"] ?>&output=embed" width="550" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe></li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="custom-hr">
        <?php

        //Si le user est connecté il peut ajouter un commentaier
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
            /*Si user n'est pas connecté on affiche un message*/
        } else {
            echo " <p><a href='login.php'>Login or signup</a> to make a comment</p>";
        } ?>
        <hr class="custom-hr">

        <?php

        /*les commentaires sont visibles pour tous les visiteurs*/
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

                            <img src='layout/images/imgprofile.png?>'>
                            <strong class="text-center"><?php echo $comment["nickname"] ?></strong>
                        </div>
                        <div class="col-md-10">
                            <p class="lead"><?php echo $comment['comment'] ?></p>
                        </div>
                    </div>
                    <hr class="custom-hr">
                </div>

        <?php }
        } ?>

    </div>

<?php } else {
    header("location:index.php");
    exit();
} ?>




<?php
include "./includes/templates/footer.php";
ob_end_flush();
?>