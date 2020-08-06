<?php
include "./includes/templates/header.php";
include "connect.php";
include "./includes/func/functions.php";
?>

<?php
if (isset($_SESSION['userid'])) {
	if ($_GET['do'] == "add") {
		$categor = $con->prepare('SELECT * FROM categor where parent_id =?');
		$categor->execute([0]);
		$cats = $categor->fetchAll();
?>
		<div class="container headingCreate">
			<h3 class="text-center">In which category would you like your event to be referenced ?</h3>
			<hr class="custom-hr">
			<div class="row">
				<div class="btns-cat">
					<ul class='list-unstyled'>
						<?php
						foreach ($cats as $cat) {
							echo '<li class="col-md-3"><a class="btn" href =event_form.php?do=create&id=' . $cat['id_category'] . '>' . $cat["name"] . ' </a></li>';
						}
						?>
				</div>
			</div>
		</div>
	<?php } elseif ($_GET["do"] ==  'create') { ?>

		<div class="container login-page">
			<div class="text-center"><a class="btn btn-info" href=<?php echo $_SERVER['HTTP_REFERER'] ?>>Change the category</a></div>
			<h1 class="text-center">Create event</h1>
			<!--Form create event-->
			<form method="POST" action=<?php echo "?do=insert&id=" . $_GET['id'] . "" ?> enctype="multipart/form-data">
				<input class="form-control" type="text" name="title" autocomplete="off" placeholder="Give your event a title" required="required" />
				<input class="form-control" type="date" name="date_debut" placeholder="yyyy-mm-jj"></p>
				<textarea class="form-control" name="description" rows="8" cols="45" autocomplete="off" placeholder="Explain what will take place" required="required"></textarea>
				<label> In which category would you like your event to be referenced ?</label>
				<select class="form-control" name="id_category">
					<?php
					$categor = $con->prepare('SELECT * FROM categor WHERE parent_id = ? ');
					$categor->execute([$_GET['id']]);
					$cats = $categor->fetchAll();

					foreach ($cats as $cat) {
						echo '<option value="' . $cat['id_category'] . '">' . $cat['name'] . '</option>';
					} ?>
				</select>
				<input type="file" name="event-img">
				<input class="btn btn-info btn-block" type="submit" name="submit">

			</form>
		</div>


<?php


	} elseif ($_GET['do'] == 'insert') {

		echo "Welcome in insert page";

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
		if ($imgSize > 3000000) {

			$formError[] = "This file can't be empty";
		}

		print_r($formError);

		if (empty($formError)) {
			$imageEvent = rand(0, 10000000000) . '_' . $imgName;
			move_uploaded_file($imgTmp, "layout\images\\" . $imageEvent);
			echo $imageEvent;

			$req = $con->prepare('INSERT INTO events(title,author,description,id_category,id_sub,image,date_debut) VALUES(?, ?, ?, ?, ?, ? ,?)');
			$req->execute(array($_POST['title'], $_SESSION['userid'], $_POST['description'], $_GET['id'], $_POST['id_category'], $imageEvent, $_POST['date_debut']));

			echo '<p class="alert alert-info" align="center" color="green">Your event has been added to our database</p>';
			header("refresh: 1; url = profile.php");
			exit();
		} else {
			echo '<p align="center" color="red">All fields are required !<p>';
		}
	}
} else {
	echo 'You must be logged in to access this page. Please <a href="login.php">log to your account</a>';
}

include "./includes/templates/footer.php";
?>