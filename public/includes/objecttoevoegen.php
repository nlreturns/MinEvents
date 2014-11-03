<?php
use minevents\app\classes\Object as Object;
use minevents\app\classes\Afdeling as Afdeling;
$afdeling = new Afdeling();
$afdeling_array = $afdeling->getList();

$countArray = count($afdeling_array);
?>
<form method="post" class="formulier">
    <h2>Object toevoegen</h2>
    <table>
        <tr>
            <td>
                <label for="object">Naam Object</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="object" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="afdelingid">Bij welke afdeling hoort het object?</label>
            </td>
        </tr>
        <tr>
            <td>
                <select name="afdelingid" title="Specifeer hier het object van de storing" required>
                    
                    <option>Maak een keuze</option>
                    <?php 
                    for ($i = 0; $i < $countArray; $i++) {
                        echo '<option value="'.$afdeling_array[$i]['afdeling_id'].'">'.$afdeling_array[$i]['afdeling_naam'].'</option>';
                    }
                    ?>
                </select>
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
    $object = new Object();
    $object->setObjectNaam($_POST['object']);
    $object->setAfdelingId($_POST['afdelingid']);
     // Ticket opslaan in database
     
    $object->create();
   
    echo "<div id='result'>";
    echo 'Uw object is <strong>succesvol</strong> aangemaakt!';
    echo "</div>";
}
?>