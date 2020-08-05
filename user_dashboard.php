<?php
include "./includes/templates/header.php";
include "connect.php";
include "./includes/func/functions.php";


if (isset($_SESSION['userid'])) { ?>

    <h2 style="font-size:50px; margin: 50px 100px;">My Dashboard</h2>

    <h3 class="h3-dashboard">Created Events</h3>

<?php $createdevents = $con -> prepare('SELECT * FROM events ev JOIN users u ON ev.author = u.id JOIN categor ca ON ca.id_category = ev.id_category WHERE author=? ORDER BY `date_debut` DESC');

$createdevents->execute(array($_SESSION["userid"]));
$mycreatedevents=$createdevents->fetchAll();

?>

        <section class="events">
            <div class="container">
                <div class="row">
                    <?php 
                    foreach ($mycreatedevents as $ce) { ?>
                    <div class="col-sm-4">
                        <div class="event">	
                            <div class="img-container">	
                                <img src="layout/images/event.JPG">
                            </div>
                            <ul class="info-event list-unstyled">
                                <li class="text-center"> <?php echo $ce['title']?></li>
                                <li class="text-center"> <?php echo $ce['date_debut']?></li>
                                <li class="text-center"> <?php echo $ce['name']?></li>
                                <!-- Edit Event -->
                                <?php echo '<a href="user_dashboard.php?edit_id_event=' . $ce['id_event'] . '" class="btn btn-success text-center btn-block">Edit (not working yet)</a>';?>
                                <!-- Delete Event -->
                                <?php echo '<a href="user_dashboard.php?delete_id_event=' . $ce['id_event'] . '" class="btn btn-danger text-center btn-block" >Delete</a>';
                                
                                if(isset($_GET['delete_id_event'])) {
                                    $delete_id_event = (int) $_GET['delete_id_event'];
                                    $req = $con->prepare('DELETE FROM events WHERE id_event = ?');
                                    $req->execute(array($delete_id_event));

                                    header("Location: user_dashboard.php");
                                }
                                ?>
                                
                            </ul>
                        </div>
                    </div>
                <?php } ?>	
                </div>
            </div>
        </section>

    <h3 class="h3-dashboard">Booked Events</h3>

<?php $bookedevents = $con -> prepare('SELECT * FROM events e JOIN association a ON  id_event = participate_eventid JOIN users u ON id = author JOIN categor c ON e.id_category = c.id_category WHERE participate_userid=?  AND date_debut > ? ORDER BY `date_debut` DESC');

$bookedevents->execute(array($_SESSION["userid"], date("Y-m-d H:i:s")));
$mybookedevents=$bookedevents->fetchAll();

?>

        <section class="events">
            <div class="container">
                <div class="row">
                    <?php 
                    foreach ($mybookedevents as $be) { ?>
                    <div class="col-sm-4">
                        <div class="event">	
                            <div class="img-container">	
                                <img src="layout/images/event.JPG">
                            </div>
                            <ul class="info-event list-unstyled">
                                <li class="text-center"> <?php echo $be['title']?></li>
                                <li class="text-center"> <?php echo $be['date_debut']?></li>
                                <li class="text-center"> <?php echo $be['name']?></li>
                                <?php echo '<a href="event_show.php?eventID=' . $be['id_event'] . '" class="btn btn-info text-center btn-block">Check Details</a>';?>
                                <a href="event_participate.php?cancel_userid=<?php echo $_SESSION['userid']; ?>&cancel_eventid=<?php echo $be['id_event']; ?>&from_dashboard=yes" class="btn btn-danger text-center btn-block">Cancel Participation</a>
                            </ul>
                        </div>
                    </div>
                <?php } ?>	
                </div>
            </div>
        </section>

    <h3 class="h3-dashboard">Booked Past Events</h3>

<?php $pastbookedevents = $con -> prepare('SELECT * FROM events e JOIN association a ON  id_event = participate_eventid JOIN users u ON id = author JOIN categor c ON e.id_category = c.id_category WHERE participate_userid=?  AND date_debut <= ? ORDER BY `date_debut` DESC');

$pastbookedevents->execute(array($_SESSION["userid"], date("Y-m-d H:i:s")));
$mypastbookedevents=$pastbookedevents->fetchAll();

?>

        <section class="events">
            <div class="container">
                <div class="row">
                    <?php 
                    foreach ($mypastbookedevents as $be) { ?>
                    <div class="col-sm-4">
                        <div class="event">	
                            <div class="img-container">	
                                <img src="layout/images/event.JPG">
                            </div>
                            <ul class="info-event list-unstyled">
                                <li class="text-center"> <?php echo $be['title']?></li>
                                <li class="text-center"> <?php echo $be['date_debut']?></li>
                                <li class="text-center"> <?php echo $be['name']?></li>
                                <?php echo '<a href="event_show.php?eventID=' . $be['id_event'] . '" class="btn btn-info text-center btn-block">Check Details</a>';?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>	
                </div>
            </div>
        </section>






<?php } else { //end - if (logged in)
    echo 'You must be logged in to access this page. Please <a href="login.php">log to your account</a>';
}

include "./includes/templates/footer.php";

?>