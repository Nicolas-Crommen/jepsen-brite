<?php
include "./includes/templates/header.php";
include "./includes/func/functions.php";
include "connect.php";


$stmt = $con->prepare("SELECT * FROM events ev JOIN users u ON ev.author = u.id JOIN categor ca ON ca.id_category = ev.id_category ORDER BY ev.date_debut DESC");
$stmt->execute();
$events = $stmt->fetchAll();


?>

<section class="events">
	<div class="container">
		<h1>Events</h1>
		<d niv class="row">
			<?php
			foreach ($events as $event) {
			?>
				<div class="col-sm-4">
					<div class="event border-style">
						<div class="over">
							<p class="text-center"><?= $event['title'] ?></p>
							<a class="showBtn btn btn-info" href="event_show.php?eventID=<?= $event["id_event"] ?>">More details +</a>
						</div>
						<div class="img-container">
							<img src='layout/images/<?= $event["image"] ?>'>
						</div>
						<ul class="info-event list-unstyled">
							<li> <strong> category : <?= $event['name'] ?></strong></li>
							<li class="author">created by <?= $event['nickname'] ?> </li>
							<li class="date-event"><?= formatDate($event['date_debut']) ?> </li>

						</ul>
					</div>
				</div>
			<?php

			} ?>




	</div>
	</div>


</section>