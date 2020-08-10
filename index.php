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
							<?php if ($event['image_type'] == 1) {
                        		echo '<img src="' . $event['image'] . '">';
                    		} elseif ($event['image_type'] == 2) {
                        		echo '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/' . $event['image'] . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    		} elseif ($event['image_type'] == 3) {
                        		echo '<iframe src="https://player.vimeo.com/video/' . $event['image'] . '" width="100%" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
                    		}
                    	?>
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