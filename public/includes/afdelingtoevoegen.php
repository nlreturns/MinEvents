<?php
use minevents\app\classes\Afdeling as Afdeling;

if(isset($_POST['Verzenden'])) {
    $afdeling = new Afdeling();
    $titel = filter_input(
        INPUT_POST, 'titel', FILTER_SANITIZE_SPECIAL_CHARS
    );
    $beschrijving = filter_input(
        INPUT_POST, 'beschrijving', FILTER_SANITIZE_SPECIAL_CHARS
    );
    $afdeling->add($titel, $beschrijving);

    echo "<div id='result'>";
    echo 'Uw Afdeling is <strong>succesvol</strong> aangemaakt!';
    echo "</div>";
}
?>
<form method="post" class="formulier">
    <h2>Ticketformulier</h2>
    <table>
        <tr>
            <td>
                <label for="afdeling">Afdeling naam</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="titel" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="beschrijving">Afdeling beschrijving</label>
            </td>
        </tr>
        <tr>
            <td>
                <textarea name="beschrijving"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" class="knopje" name="Verzenden" value="Aanmaken" />
            </td>
        </tr>
    </table>
</form>