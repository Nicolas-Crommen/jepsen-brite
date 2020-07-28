
<?php
include "./includes/templates/header.php";
include "connect.php";
include "./includes/func/functions.php";
?>

<?php
if (isset($_SESSION['userid'])) {
    echo "Hello, " . $_SESSION['nickname'];
}
?>


<?php

$lst = $con -> prepare('SELECT * FROM events WHERE id=?');

$lst->execute(array($_GET['id']));
$donnees=$lst->fetchAll();
?>

<div class="events-grid">
<?php foreach ($donnees as $item) { ?>
	<div class="col-xs-6 col-md-3" id="event-item">
		<h4 class="text-center"> <?php echo $item['title']?></h4>
		<h5 class="text-center"> <?php echo $item['time']?></h5>
		<h6 class="text-center"> <?php echo $item['category']?></h6>
		<p class="text-center">Decription : <?php echo $item['description']?></p>
		<p color="red"><strong>Are you sure this event has to be deleted ?</strong></p>
		<a class="btn btn-danger text-center btn-block" href="">Delete</a> <a class="btn btn-info text-center btn-block" href="">Cancel</a>
	</div>

<?php
}
?>
</div>


<?php
include "./includes/templates/footer.php";
?>