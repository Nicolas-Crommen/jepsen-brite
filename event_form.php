<?php
include "./includes/templates/header.php";
include "connect.php";
include "./includes/func/functions.php";
?>

<?php
if (isset($_SESSION['userid'])) { ?>

	<div class="container login-page">
		<h1 class="text-center">Create event</h1>
		<form method="post" action="event_form.php" enctype="multipart/form-data">
			<p>
				<input class="form-control" type="text" name="title" autocomplete="off" placeholder="Give your event a title" required="required" />
			</p>
			<p><input class="form-control" type="date" name="date_debut" placeholder="yyyy-mm-jj"></p>
			<p>
				<textarea class="form-control" name="description" rows="8" cols="45" autocomplete="off" placeholder="Explain what will take place" required="required"></textarea>
			</p>
			<p>In which category would you like your event to be referenced ?
				<select class="form-control" name="id_category">
					<?php
					$categor = $con->prepare('SELECT * FROM categor');
					$categor->execute();
					$cats = $categor->fetchAll();
					foreach ($cats as $cat) {
						echo '<option value="' . $cat['id_category'] . '">' . $cat['name'] . '</option>';
					} ?>
				</select>
			</p>
			<input type="file" name="event-img">
			<input class="btn btn-info btn-block" type="submit" name="submit">
		</form>
	</div>


<?php

	if (isset($_POST['title']) and isset($_POST['description']) and isset($_POST['id_category']) and isset($_POST['date_debut'])) {


		$imgName = $_FILES['event-img']['name'];
		$imgSize = $_FILES['event-img']['size'];
		$imgTmp	= $_FILES['event-img']['tmp_name'];
		$imgType = $_FILES['event-img']['type'];

		$formError = array();
		$allwoedExtensoion = array("jpeg", "jpg", "png", "gif");

		$file_extension = pathinfo($imgName, PATHINFO_EXTENSION);

		if (!empty($imgName) && !in_array(strtolower($file_extension), $allwoedExtensoion)) {
			$formError[] = "this file format is not valid";
		}
		if (empty($imgName)) {
			$formError[] = "This file can't be empty";
		}
		if ($imgSize > 500000) {

			$formError[] = "This file can't be empty";
		}

		if (empty($formError)) {
			$imageEvent = rand(0, 10000000000) . '_' . $imgName;
			move_uploaded_file($imgTmp, "layout\images\\" . $imageEvent);
			echo $imageEvent;

			$req = $con->prepare('INSERT INTO events(title,author,description,id_category,image,date_debut) VALUES(?, ?, ?, ?, ?, ?)');
			$req->execute(array($_POST['title'], $_SESSION['userid'], $_POST['description'], $_POST['id_category'], $imageEvent, $_POST['date_debut']));

			echo '<p class="" align="center" color="green">Your event has been added to our database</p>';
		}
	} else {
		echo '<p align="center" color="red">All fields are required !<p>';
	}
} else {
	echo 'You must be logged in to access this page. Please <a href="login.php">log to your account</a>';
}

include "./includes/templates/footer.php";
?>