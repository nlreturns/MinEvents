<?php
include_once 'classes/defs/constants.php';
include_once 'classes/defs/db_constants.php';
include_once 'classes/gebruiker.php';
//include_once 'classes/Gebruikerrecht.php';
include_once 'classes/RechtGroep.php';
session_start();
// Rechtgroep aanmaken
$rechtgroep = new RechtGroep();
// Nieuwe rechtgroep (naam, beschrijving

$rechtgroep->setRechtgroepNaam('test');
$rechtgroep->setRechtGroepBeschrijving('Een Test groep');
$rechtgroep->addRechtgroepRecht(3);
$rechtgroep->addRechtgroepRecht(40);
$rechtgroep->addRechtgroepRecht(65);
$rechtgroep->saveRechtGroep();


echo'<hr />';
$gebruiker = new Gebruiker(new DbGebruiker());
// Test gebruiker aanmaken

    //$recht = RechtGroep::getRechtgroepbyName("Admin");
$id = 1;
//$recht = Gebruiker::getRechtgroepById($id);
$gebruiker->setGebruikerNaam('Donny');
$gebruiker->setGebruikerWachtwoord('test');
$gebruiker->setGebruikerTijd('2013-12-15 23:20:15');
$gebruiker->setRechtGroepId(32);
$gebruiker->setSessieId(1);
$gebruiker->addGebruiker();
//$gebruiker->setRecht($recht);





//$gebruikerrecht = new GebruikerRecht();
$gebruiker->addRecht(3);
$gebruiker->addRecht(40);
$gebruiker->addRecht(65);



//$recht = new GebruikerRecht();
// Voeg een aantal rechten toe (Niet opeenvolgend)
// minimaal 1 tussen 0 en 32, 1 tussen 32 en 64, 1 tussen 64 en 96


echo '<pre>';
var_dump($gebruiker);
echo'</pre><hr />';
$test = array(1, 3, 31, 32, 33, 40, 65, 2048);
foreach($test as $idx => $value) {
    if($gebruiker->heeftRecht($value)) {
        echo $value . '= :)<br />';
    } else {
        echo $value . '= :(<br />';
    }
}

// Sla bitveld op in database (JSON ?? serialize)


// Haal op uit database (unserialize) en check


// check object