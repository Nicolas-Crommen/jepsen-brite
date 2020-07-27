
<?php
include "./includes/templates/header.php";
include "./includes/func/functions.php";
?>

<?php
if (isset($_SESSION['userid'])) {
    echo "Hello" . $_SESSION['nickname'];
}
?>


<p class="text-center">Welcome on the home Page ! Take a look at our latest events.</p>

<?php

try {
$bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite-db;charset=utf8','root','root');
} catch (Exception $e) {
die('Erreur : ' . $e -> getMessage() );
}

$lst = $bdd -> prepare('SELECT * FROM events ORDER BY "date" DESC LIMIT 12');

$lst->execute();
$donnees=$lst->fetchAll();
?>

<div class="events-grid">
<?php foreach ($donnees as $item) { ?>
	<div class="col-xs-6 col-md-3" id="event-item">
		<h4 class="text-center"> <?php echo $item['title']?></h4>
		<h5 class="text-center"> <?php echo $item['time']?></h5>
		<h6 class="text-center"> <?php echo $item['category']?></h6>
		<p class="text-center">Decription : <?php echo $item['description']?></p>
	</div>

<?php
}
?>
</div>

<?php
include "./includes/templates/footer.php";
?>