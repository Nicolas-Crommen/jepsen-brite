<?php
include "./includes/templates/header.php";
		
try {
$bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite-db;charset=utf8','root','root');
} catch (Exception $e) {
die('Erreur : ' . $e -> getMessage() );
}
	
if (isset($_POST['title']) AND isset($_POST['description']) AND isset($_POST['category'])) {
	


	$req = $bdd -> prepare('INSERT INTO events(title,author,description,category) VALUES(?, ?, ?, ?)');

	$req -> execute(array($_POST['title'], 1, $_POST['description'], $_POST['category']));

	echo "Your event has been added to our database";
}
else
{
	echo "All fields are required";
}
 
?>

<form method="post" action="event_form.php">
	<p>
		<input type="text" name="title" value="Give your event a title" />
	</p>
	<p>
		<textarea name="description" rows="8" cols="45">Explain what will take place</textarea>
	</p>
	<p>In which category would you like your event to be referenced ?
		<select name="category">
			<option value="concert">Concert</option>
			<option value="expo">Exhibition</option>
			<option value="cinema">Cinema</option>
			<option value="talk">Talk</option>
			<option value="party">Party</option>
			<option value="other">Other</option>
		</select>
	</p>
	<input type="submit" name="submit">
</form>

<?php
include "./includes/templates/footer.php";
?>