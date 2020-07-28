
<?php
include "./includes/templates/header.php";
include "connect.php";
include "./includes/func/functions.php";
?>

<?php
if (isset($_SESSION['userid'])) {

	if (isset ($_GET['do']) && $_GET['do']=='delete')
	{
	$con -> prepare('DELETE FROM events WHERE id=?');
    $del = $con -> execute(array($_GET['id']))
    echo "Your event has succesfully been deleted";
	}

	elseif (isset ($_GET['do']) && $_GET['do']=='edit')
	{
	echo 'test edit';
	}

	else 
	{
	echo '<p class="text-center">Welcome on the home Page ! Take a look at our latest events.</p>';

	$lst = $con -> prepare('SELECT * FROM events WHERE author=? ORDER BY "date" DESC');

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
			<a href=<?php echo 'user_events.php?do=edit&id=' . $item['id']?> class="btn btn-success text-center btn-block" >Edit</a>
			<a href=<?php echo 'user_events.php?do=delete&id=' . $item['id']?> class="btn btn-danger text-center btn-block" >Delete</a>
		</div>

	<?php
	}

else {
	echo 'Your are not logged in. Please go to login section in order to access your existing events';
}	
}
?>
</div>

<?php
include "./includes/templates/footer.php";
?>