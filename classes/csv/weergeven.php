<?php
//we zetten error report aan voor als er een foutje in de code zou zitten, deze kan als alles optimaal werkt uitgezet worden. Dit doe je door de 1 te veranderen in een 0.
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
 
//we includen het bestand config.php zodat we verbinding hebben met de database
include ("config.php");
 
//We hoeven eigenlijk maar gewoon 1 select query te doen en een while loop en we zijn al klaar. We d dit als volgt:
 
//de select query
$ophalen = mysql_query("SELECT * FROM personeelsgegevens") or die(mysql_error());
//while loop
while ($gegevens = mysql_fetch_array($ophalen)) {
	echo $gegevens['personeelsnummer']; // personeelsnummer uitlezen
	echo '<br />';
	echo $gegevens['username']; //username uitlezen
	echo '<br />';
	echo $gegevens['password']; //username uitlezen
	echo '<br />';
	echo $gegevens['naam']; //username uitlezen
	echo '<br />';
	echo '<hr />';
}
?>