<?php

include_once 'classes/gebruiker.php';
$recht_array = $reflection->getConstants();
$gebruiker = new Gebruiker(new DbGebruiker());
$user = $gebruiker->getGebruikerById($_GET['id']);

if ($gebruiker->heeftRecht($_SESSION['gebruiker_recht'], $recht_array['RIGHT_VIEW_USER'])) {
    echo 'U heeft geen rechten voor deze pagina.';
} else {
    if (isset($_POST['update'])) {
        // set everything
        $gebruiker->setGebruikerNaam($user['gebruiker_naam']);
        $gebruiker->setSessieId($user['sessie_id']);
        $gebruiker->setGebruikerId($_GET['id']);
        $gebruiker->setGebruikerWachtwoord($user['gebruiker_wachtwoord']);
        // save, giving right array (for correct serialize)
        $gebruiker->updateGebruiker($_POST['recht']);

        // reset user info
        $user = $gebruiker->getGebruikerById($_GET['id']);
    }
    echo '<form method="post">';
    echo '<table class="tabel">';
    echo '<tr>';
    echo '<th>Naam</th>';
    echo '<td>';
    echo $user['gebruiker_naam'];
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th>Registratie tijd</th>';
    echo '<td>';
    echo $user['gebruiker_tijd'];
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th>Rechten</th>';
    echo '<td>';
    foreach ($recht_array as $key => $value) {
        $has_recht = false;
        foreach ($user['gebruiker_recht'] as $bit) {
            if ($value == $bit) {
                $has_recht = true;
            }
        }
        if ($has_recht == true) {
            // check the box
            echo $key;
            echo '<input type="checkbox" name="recht[]" value="' . $value . '" checked />';
            echo '<br />';
        } else {
            // uncheck the box
            echo $key;
            echo '<input type="checkbox" name="recht[]" value="' . $value . '" />';
            echo '<br />';
        }

        $has_recht = false;
    }

    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td></td><td><input type="submit" name="update" value="Opslaan"';
    echo '</td></tr>';
    echo '</table>';
    echo '</form>';
}