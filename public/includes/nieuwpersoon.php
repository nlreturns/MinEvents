<?php
use minevents\app\classes\Persoon as Persoon;
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
                <select name="land" id="land" title="Kies een land." required>
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
                <input type="text" name="telefoon_nummer" id="titel" title="Voer hier het telefoon nummer in." required>
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
    $persoon = new Persoon();
    $persoon->setPersoonVoornaam($_POST['voornaam']);
    $persoon->setPersoonAchternaam($_POST['achternaam']);
    $persoon->setPersoonEmail($_POST['email']);
    $persoon->setPersoonStraat($_POST['straat']);
    $persoon->setPersoonStad($_POST['stad']);
    $persoon->setPersoonLand($_POST['land']);
    $persoon->setPersoonTelnummer($_POST['telefoon_nummer']);
    /**
     * persoon opslaan in database
     */
    if($persoon->addPersoon()){
        echo "<div id='result'>";
        echo 'Uw persoon is <strong>succesvol</strong> aangemaakt!';
        echo "</div>";
    }else{
        echo "<div id='bad_result'>";
        echo "Wachtwoord moet minimaal acht tekens bevatten!";
        echo "</div>";
    }
}
?>