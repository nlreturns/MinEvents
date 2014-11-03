<?php
include_once '../app/core/SplClassLoader.php';
include_once '../app/config/constants.php';
include_once '../app/config/db_constants.php';
$autoloader = new \minevents\app\core\SplClassLoader('minevents\app', '../../');
$autoloader->register();
// Nieuw object van Login class
$login = new \minevents\app\classes\Loginsysteem();
// Controleer of gebruiker al ingelogd is, zoja ga dan naar de index pagina
if($login->isloggedin()){
    header("Location: index.php");
    exit;
} else {
if(isset($_POST['inloggen'])) {
    echo ':S';
    // username setten in Login class
	$login->setUsername($_POST['gebruikersnaam']);
    // password setten in Login class
	$login->setPassword($_POST['wachtwoord']);
    // Kijk of gegevens kloppen login
	$login->login();
	// Ga naar index pagina
	header("Location: index.php");
	exit;
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>M in Events | Inloggen</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div id="loginwrap">
		<form method="POST" class="formulier">
			<table>
				<tr>
					<td>
						<h2>Inloggen</h2>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="gebruikersnaam" placeholder="Gebruikersnaam">
					</td>
				</tr>
				<tr>
					<td>
						<input type="password" name="wachtwoord" placeholder="Wachtwoord">
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" class="knopje" name="inloggen" value="Inloggen">
					</td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>
<?php
}
?>