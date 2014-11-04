<?php
use minevents\app\classes\Afdeling as Afdeling;
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
                <input type="text" name="afdeling" />
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
<?php
if(isset($_POST['Verzenden'])) {
    /**
     * Nieuwe instantie van ticketsysteem maken.
     * Alles setten.
     */
    $afdeling = new Afdeling();
     // Ticket opslaan in database
    $afdeling->add($_POST['afdeling'], $_POST['beschrijving']);
   
    echo "<div id='result'>";
    echo 'Uw Afdeling is <strong>succesvol</strong> aangemaakt!';
    echo "</div>";
}
?>