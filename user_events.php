
<?php
include "./includes/templates/header.php";
include "connect.php";
include "./includes/func/functions.php";
?>

<?php
if (isset($_SESSION['userid'])) {

// Application des modifs
	if (isset($_POST['title']) AND isset($_POST['description']) AND isset($_POST['category']) AND isset($_POST['time'])) {

	$edt = $con -> prepare('UPDATE events SET title=?, description=?, category=?, `time`=? WHERE id=?)');
	$edt -> execute(array($_POST['title'], $_POST['description'], $_POST['category'], $_POST['time'], $_GET['id']));

	echo '<p class="" align="center" color="green">Your event has been modified</p>';
	}
	else
	{
		echo '<p align="center" color="red">All fields are required !<p>';
	}
		

	
// Delete event
	if (isset ($_GET['do']) && isset ($_GET['id']) && $_GET['do']=='delete')
	{
	$del = $con -> prepare('DELETE FROM events WHERE id=?');
    $del -> execute(array($_GET['id']));
    echo "Your event has succesfully been deleted";
	}

// Edit event	
	elseif (isset ($_GET['do']) && isset ($_GET['id']) && $_GET['do']=='edit')
	{
	$evt = $con -> prepare('SELECT * FROM events WHERE id=?');
	$evt->execute(array($_GET['id']));
	$data_edit=$evt->fetchAll();
?>	

	<div class="events-grid">
	<?php foreach ($data_edit as $item_edit) { ?>
	<form method="post" action="<?php echo 'user_events.php?id=' . $_GET['id'] ?>">
		<p>
			<input class="form-control" type="text" name="title" autocomplete="off" value="<?php echo $item_edit['title']?>" required="required" />
		</p>
		<p><input class="form-control" type="date" name="time" value="<?php echo $item_edit['time']?>"></p>
		<p>
			<textarea class="form-control" name="description" rows="8" cols="45" autocomplete="off" required="required"><?php echo $item_edit['description']?></textarea>
		</p>
		<p>In which category would you like your event to be referenced ?
			<select class="form-control" name="category">
				<option value="" selected disabled hidden>Choose here</option>
				<option value="concert">Concert</option>
				<option value="expo">Exhibition</option>
				<option value="cinema">Cinema</option>
				<option value="talk">Talk</option>
				<option value="party">Party</option>
				<option value="other">Other</option>
			</select>
		</p>
		<input class="btn btn-info btn-block" type="submit" name="submit">
	</form>

<?php	
	}
	}


// Display user events	
	else 
	{
	echo '<p class="text-center">Welcome on your events page ! Here you can manage everything about your Jepsen Brite events</p>';

	$lst = $con -> prepare('SELECT * FROM events WHERE author=? ORDER BY `time` DESC');

	$lst->execute(array($_SESSION["userid"]));
	$donnees=$lst->fetchAll();

?>

	<div class="events-grid">
	<?php foreach ($donnees as $item) { ?>
		<div class="col-xs-6 col-md-3" id="event-item">
			<h4 class="text-center"> <?php echo $item['title']?></h4>
			<h5 class="text-center"> <?php echo $item['time']?></h5>
			<h6 class="text-center"> <?php echo $item['category']?></h6>
			<p class="text-center">Decription : <?php echo $item['description']?></p>
			<?php echo '<a href="user_events.php?do=edit&id=' . $item['id'] . '" class="btn btn-success text-center btn-block">Edit</a>';?>
			<?php echo '<a href="user_events.php?do=delete&id=' . $item['id'] . '" class="btn btn-danger text-center btn-block" >Delete</a>';?>
		</div>
	<?php } ?>
	</div>
<?php
	}
}

else
	{echo 'You must be logged in to access this page. Please <a href="login.php">log to your account</a>';}

include "./includes/templates/footer.php";
?>