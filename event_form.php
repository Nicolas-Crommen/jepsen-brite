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
	<?php } elseif ($_GET["do"] == 'create') { ?>

		<div class="container login-page">
			<div class="text-center"><a class="btn btn-info" href=<?php echo $_SERVER['HTTP_REFERER'] ?>>Change the category</a></div>
			<h1 class="text-center">Create event</h1>
			<!--Form create event-->
			<form method="POST" action="<?php echo '?do=insert&id=' . $_GET['id']; ?>" enctype="multipart/form-data">
				<input class="form-control" type="text" name="title" autocomplete="off" placeholder="Give your event a title" required="required" />
				<input class="form-control" type="date" name="date_debut" placeholder="yyyy-mm-jj"></p>
				<input class="form-control" type="time" name="time" required="required" />
				<textarea class="form-control" name="description" rows="8" cols="45" autocomplete="off" placeholder="Explain what will take place" required="required"></textarea>
				<p><input class="form-control" type="text" name="address" autocomplete="off" placeholder="Indicate here the address of your event" required="required" /></p>
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

				</p>
				<h3 class="text-center">Type of your illustration :<br /></h3>
				<select name="image_type" class="form-control" required="required">
					<option value="none" disabled="disabled" selected="selected">Choose one</option>
					<option value="1">Image</option>
					<option value="2">YouTube</option>
					<option value="3">Vimeo</option>
				</select>

				<input class="form-control" type="text" name="image" autocomplete="off" placeholder="Add your illustration URL (Image, YouTube video or Vimeo video)" required="required" />
		</div>
		<input class="btn btn-info btn-block" type="submit" name="submit">
		</form>
		</div>

<?php


	} elseif ($_GET['do'] == 'insert') {

		if (filter_var($_POST['image'], FILTER_VALIDATE_URL)) {
			if ($_POST['image_type'] == 1) {
				$illus = $_POST['image'];
			} elseif ($_POST['image_type'] == 2) {
				$illus = substr($_POST['image'], -11);
			} else {
				$illus = substr($_POST['image'], -9);
			}
			$req = $con->prepare('INSERT INTO events(title,author,description,id_category,id_sub,image,image_type,date_debut ,address) VALUES (?, ?, ?, ?, ?, ? ,? ,?,?)');
			$req->execute(array($_POST['title'], $_SESSION['userid'], $_POST['description'], $_GET['id'], $_POST['id_category'], $illus, $_POST['image_type'],  $_POST['date_debut'] . " " . $_POST['time'], $_POST['address']));

			echo '<p class="alert alert-info" align="center" color="green">Your event has been added to our database</p>';
			header("refresh: 2; url = index.php");
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