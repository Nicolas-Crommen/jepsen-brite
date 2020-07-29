<?php
include "./includes/templates/header.php";
include "./includes/func/functions.php";
include "connect.php";


$stmt = $con->prepare("select * from events ev join users u on ev.author = u.id join categor ca on ca.id_category = ev.id_category ");
$stmt->execute();
$events = $stmt->fetchAll();


?>

<section class="events">
	<div class="container">
		<h1>Events</h1>
		<div class="row">
			<?php
			foreach ($events as $event) {
			?>
				<div class="col-sm-4">
					<div class="event">
						<div class="over">
							<p class="text-center"><?php echo $event['title'] ?></p>
							<a class="showBtn btn btn-info" href="event_show.php?do=showDatails&eventID=<?php echo $event["id_event"] ?>">More details +</a>
						</div>
						<div class="img-container">
							<img src="layout/images/event.JPG">
						</div>
						<ul class="info-event list-unstyled">
							<li> <strong> category : <?php echo $event['name'] ?></strong></li>
							<li class="author">created by <?php echo $event['nickname'] ?> </li>
							<li class="date-event"><?php echo formatDate($event['date_debut']) ?> </li>

						</ul>
					</div>
				</div>
			<?php } ?>

		</div>
	</div>


</section>


<?php

?>

<?php
include "./includes/templates/footer.php";
?>