<?php
use minevents\app\classes\Gebruiker as Gebruiker;
use minevents\app\classes\db\DbGebruiker as DbGebruiker;
use minevents\app\classes\Recht as Recht;
// @TODO put constant in constant file
define("NEVER_LOGGED_IN", 2);
// nieuwe instantie van Recht
$rechtgroep = new Recht();
//Haal array op uit database met alle rechtgroepen
$recht_array = $reflection->getConstants();

$countArray = count($recht_array);
?>
<form method="post" name="form1" id="ticketform" action="#">    <h2>Gebruiker Toevoegen</h2>
    <table class="formulier">
        <tr>
            <td>
                <label for="toevoegen">Gebruikersnaam:</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="gebruikersnaam" id="titel" title="Voer hier de gebruikersnaam in." required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="wachtwoord">Wachtwoord:</label> 
            </td>
        </tr>
        <tr>
            <td>
                <input type="password" name="wachtwoord" id="titel" title="Voer hier het wachtwoord in." required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="wachtwoord_herhalen">Wachtwoord herhalen:</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="password" name="wachtwoord_herhalen" id="titel" title="Geef hier de storing een titel" required>
            </td>
        </tr>
        <tr>
            <td><label for="rechten">Rechten</label></td>
        </tr>
        <tr>
            <td>
                <?php
                // loop all rights
                foreach ($recht_array as $key => $value) {
                    echo $key;
                    echo '<input type="checkbox" name="recht[]" value="' . $value . '" />';
                    echo '<br />';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" class="knopje" name="Verzenden" value="Aanmaken" />
            </td>
        </tr>
    </table>
</form>
<?php
$good_res = "";
$bad_res = "";
if (isset($_POST['Verzenden'])) {
    if (isset($_POST['gebruikersnaam']) && isset($_POST['wachtwoord']) && isset($_POST['wachtwoord_herhalen'])) {
        if ($_POST['wachtwoord'] == $_POST['wachtwoord_herhalen']) {
            
            /**
             * Nieuwe instantie van gebruiker maken.
             * Alles setten.
             */
            $gebruiker = new Gebruiker(new DbGebruiker());
            $gebruiker->setGebruikerNaam($_POST['gebruikersnaam']);
            
            // set session to 2 (never logged in)
            $gebruiker->setSessieId(NEVER_LOGGED_IN);
            
                // check password before saving
            if ($gebruiker->checkLengteWachtwoord($_POST['wachtwoord'])) {
                $gebruiker->setGebruikerWachtwoord($_POST['wachtwoord']);
                
                // Save user, send rights with function, else serialising fails
                if ($gebruiker->addGebruiker($_POST['recht']) == true) {
                    $good_res .= 'Uw gebruiker is <strong>succesvol</strong> aangemaakt!';
                }
                // error handling
            } else {
                $bad_res .= 'Uw wachtwoord moet minimaal acht tekens bevatten.';
            }
        } else {
            $bad_res .= "Wachtwoorden komen niet overeen.";
        }
    } else {
        $bad_res .= "Gegevens zijn niet juist ingevuld.";
    }
    if (!empty($bad_res)) {
        echo '<div id="bad_result">';
        echo $bad_res;
        echo '</div>';
    }
    if (!empty($good_res)) {
        echo '<div id="result">';
        echo $good_res;
        echo '</div>';
    }
}
?>