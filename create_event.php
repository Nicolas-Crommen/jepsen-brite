<?php

try {
	$bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite-db;charset=utf8','root','root');
} catch (Exception $e) {
	die('Erreur : ' . $e -> getMessage() );
}

$bdd -> exec('INSERT INTO events(title,author,description,category,image) VALUES(\'Crash\',1,\'Un film de fous\',\'Cinéma\',\'https://www.mauvais-genres.com/12725-thickbox_default/ebay.jpg\')');

echo 'Votre événement a bien été ajouté';

?>