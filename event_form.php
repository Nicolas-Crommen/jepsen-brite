<?php
include "./includes/templates/header.php";
?>

<div class="container login-page">
	<h1 class="text-center">Create event</h1>
	<form method="post" action="event_form.php">
		<p>
			<input class="form-control" type="text" name="title" autocomplete="off" placeholder="Give your event a title" required="required" />
		</p>
		<p>
			<textarea class="form-control" name="description" rows="8" cols="45" autocomplete="off" placeholder="Explain what will take place" required="required"></textarea>
		</p>
		<p>In which category would you like your event to be referenced ?
			<select class="form-control" name="category">
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
</div>

<?php
		
try {
$bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite-db;charset=utf8','root','root');
} catch (Exception $e) {
die('Erreur : ' . $e -> getMessage() );
}
	
if (isset($_POST['title']) AND isset($_POST['description']) AND isset($_POST['category'])) {

	$req = $bdd -> prepare('INSERT INTO events(title,author,description,category,image) VALUES(?, ?, ?, ?, ?)');

	$req -> execute(array($_POST['title'], $_SESSION['userid'],$_POST['description'], $_POST['category'], 'image.com'));

	echo '<p class="" align="center" color="green">Your event has been added to our database</p>';
}
else
{
	echo '<p align="center" color="red">All fields are required !<p>';
}
 
?>



<?php
include "./includes/templates/footer.php";
?>