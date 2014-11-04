<?php
include_once '../app/Bootstrap.php';
$bootstrap = new \minevents\app\Bootstrap();
use minevents\app\classes as classes;

$rechten = new classes\RechtenConstants();
$reflection = new ReflectionClass($rechten);
$recht_array = $reflection->getConstants();
$login = new classes\Loginsysteem();
$gebruiker = new classes\Gebruiker(new classes\db\DbGebruiker());
$recht = new classes\GebruikerRecht();
if (!$login->isloggedin()) {
    header("Location: login_scherm.php");
    exit;
} else {
include_once 'includes/header.php';

include_once 'includes/content.php';

include_once 'includes/footer.php';

}
