<?php
use minevents\app\classes\Gebruiker as Gebruiker;
use minevents\app\classes\db\DbGebruiker as DbGebruiker;
?>
<form method="post" name="form1" id="ticketform" action="#">    <h2>Persoon Toevoegen</h2>
    <table class="formulier">
        <tr>
            <td>
                <label for="toevoegen">Voornaam:</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="voornaam" id="titel" title="Voer hier de voornaam in." required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="toevoegen">Achternaam:</label> 
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="achternaam" id="titel" title="Voer hier de achternaam in." required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="toevoegen">Email:</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="email" id="titel" title="Voer hier uw email in." required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="afdeling">Land:</label>
            </td>
        </tr>
        <tr>
            <td>
                <select name="afdeling" id="afdeling" title="Kies hier de afdeling waar de storing zich voordoet" required>
                    <option>Maak een keuze</option>
                    <option>Nederland</option>
                    <option>Belgie</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="toevoegen">Stad:</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="stad" id="titel" title="Voer hier de stad in waar u woont." required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="toevoegen">Straat:</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="straat" id="titel" title="Voer hier de straat in waar u woont." required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="toevoegen">Telefoon nummer:</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="telefoon nummer" id="titel" title="Voer hier het telefoon nummer in." required>
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
if (isset($_POST['Verzenden'])) {
    /**
     * Nieuwe instantie van ticketsysteem maken.
     * Alles setten.
     */
    $gebruiker = new Gebruiker(new DbGebruiker());
    $gebruiker->setGebruikerNaam($_POST['gebruikersnaam']);
    $gebruiker->setRechtGroepId(1);
    $gebruiker->setSessieId(2);
    $gebruiker->setGebruikerWachtwoord($_POST['wachtwoord']);
    /**
     * gebruiker opslaan in database
     */
    if($gebruiker->addGebruiker()){
        echo "<div id='result'>";
        echo 'Uw gebruiker is <strong>succesvol</strong> aangemaakt!';
        echo "</div>";
    }else{
        echo "<div id='bad_result'>";
        echo "Wachtwoord moet minimaal acht tekens bevatten!";
        echo "</div>";
    }
}
?>