<?php
include "./includes/templates/header.php";
include "connect.php";
include "./includes/func/functions.php";
?>

<?php
if (isset($_SESSION['userid'])) {

	// Application des modifs
	if (isset($_GET['id']) and $_GET['do'] == 'edit_apply') {
		if (isset($_POST['title']) and isset($_POST['description']) and isset($_POST['id_category']) and isset($_POST['date_debut'])) {
			$edt = $con->prepare('UPDATE events SET title=?, author=?, description=?, id_category=?, `date_debut`=?, image=? WHERE id_event=?');
			$edt->execute(array($_POST['title'], $_SESSION["userid"], $_POST['description'], $_POST['id_category'], $_POST['date_debut'], 'image.com', $_GET['id']));

			echo '<p class="" align="center" color="green">Your event has been modified</p>';
		}
	}
	// Delete event
	if (isset($_GET['do']) && isset($_GET['id']) && $_GET['do'] == 'delete') {
		$evt = $con->prepare('SELECT * FROM events WHERE id_event=?');
		$evt->execute(array($_GET['id']));
		$data_del = $evt->fetchAll();
?>
		<div class="container login-page">
			<?php foreach ($data_del as $item_del) { ?>
				<div class="col-sm-4">
					<div class="event">
						<div class="img-container">
							<img src="layout/images/<?php echo $item_del['image'] ?>">
						</div>
						<ul class="info-event list-unstyled">
							<li class="text-center"><b>This event will be deleted :</b></li>
							<li class="text-center"> <?php echo $item_del['title'] ?></li>
							<li class="text-center"> <?php echo $item_del['date_debut'] ?></li>
						</ul>
						<a href="user_events.php" class="btn btn-success text-center btn-block">Cancel</a>
						<a href="user_events.php?do=confirm_delete&id=<?php echo $item_del['id_event'] ?>" class="btn btn-danger text-center btn-block">Delete event</a>
					</div>
				</div>
		</div>
	<?php
			}
		}

		if (isset($_GET['do']) && isset($_GET['id']) && $_GET['do'] == 'confirm_delete') {
			$del = $con->prepare('DELETE FROM events WHERE id_event=?');
			$del->execute(array($_GET['id']));
			echo '<p class="text-center"><b>Your event has succesfully been deleted</br></b></p>';
			echo '<a href="user_events.php" class="btn btn-success text-center btn-block">Back to My Events</a>';
		}

		// Edit event	
		elseif (isset($_GET['do']) && isset($_GET['id']) && $_GET['do'] == 'edit') {
			$evt = $con->prepare('SELECT * FROM events WHERE id_event=?');
			$evt->execute(array($_GET['id']));
			$data_edit = $evt->fetchAll();
	?>

	<div class="container login-page">
		<?php foreach ($data_edit as $item_edit) { ?>
			<form method="post" action="<?php echo 'user_events.php?do=edit_apply&id=' . $_GET['id'] ?>">
				<p>
					<input class="form-control" type="text" name="title" autocomplete="off" value="<?php echo $item_edit['title'] ?>" required="required" />
				</p>
				<p><input class="form-control" type="date" name="date_debut" value="<?php echo $item_edit['date_debut'] ?>"></p>
				<p>
					<textarea class="form-control" name="description" rows="8" cols="45" autocomplete="off" required="required"><?php echo $item_edit['description'] ?></textarea>
				</p>
				<p>In which category would you like your event to be referenced hello ?
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
				<input class="btn btn-info btn-block" type="submit" name="submit">
			</form>
	</div>

<?php
			}
		}


		// Display user events	
		else {

			$lst = $con->prepare('SELECT * FROM events ev JOIN users u ON ev.author = u.id JOIN categor ca ON ca.id_category = ev.id_category WHERE author=? ORDER BY `date_debut` DESC');

			$lst->execute(array($_SESSION["userid"]));
			$donnees = $lst->fetchAll();

?>

<section class="events">
	<div class="container">
		<h1>My events</h1>
		<div class="row">
			<?php
			foreach ($donnees as $item) { ?>
				<div class="col-sm-4">
					<div class="event">
						<div class="img-container">
							<img src="layout/images/<?php echo $item['image'] ?>">
						</div>
						<ul class="info-event list-unstyled">
							<li class="text-center"> <?php echo $item['title'] ?></li>
							<li class="text-center"> <?php echo $item['date_debut'] ?></li>
							<li class="text-center"> <?php echo $item['name'] ?></li>
							<?php echo '<a href="user_events.php?do=edit&id=' . $item['id_event'] . '" class="btn btn-success text-center btn-block">Edit</a>'; ?>
							<?php echo '<a href="user_events.php?do=delete&id=' . $item['id_event'] . '" class="btn btn-danger text-center btn-block" >Delete</a>'; ?>
						</ul>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
<?php
		}
	} else {
		echo 'You must be logged in to access this page. Please <a href="login.php">log to your account</a>';
	}

	include "./includes/templates/footer.php";
?>