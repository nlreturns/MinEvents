<?php
include_once FILE_TICKETSYSTEEM;
include_once FILE_AFDELING;
include_once FILE_OBJECT;
include_once FILE_PRIORITEIT;

if (isset($_POST['Verzenden'])) {
    /**
     * Nieuwe instantie van ticketsysteem maken.
     * Alles setten.
     */
    $ticket = new TicketSysteem();
    $ticket->__set('titel', $_POST['titel']);
    $ticket->__set('afdeling', $_POST['afdeling']);
    $ticket->__set('object', $_POST['object']);
    $ticket->__set('beschrijving', $_POST['beschrijving']);
    $ticket->__set('progress', 'open');
    $ticket->__set('creator_id', $_SESSION['user_id']);
    $ticket->setCreatedate();
    /**
     * Ticket opslaan in database
     */
    $ticket->saveTicket();

    echo "<div id='result' style='width: 300px; float: none;'>";
    echo 'Uw ticket is <strong>succesvol</strong> aangemaakt!';
    echo "</div>";
}

$object = new Object();
$afdeling = new Afdeling();
$prioriteit = new Prioriteit();

$object_array = $object->getList();
$afdeling_array = $afdeling->getList();
$prioriteit_array = $prioriteit->getList();

$count_prioriteit_array = count($prioriteit_array);
$count_afdeling_array = count($afdeling_array);
$count_object_array = count($object_array);
?>
<form method="post" name="form1" id="ticketform" action="#">
    <h2>Ticketformulier</h2>
    <table class="formulier">
        <tr>
            <td>
                <label for="afdeling">Afdeling</label>
            </td>
        </tr>
        <tr>
            <td>
                <select name="afdeling" id="afdeling" title="Kies hier de afdeling waar de storing zich voordoet" required>
                    <option>Maak een keuze</option>
                    <?php
                    for ($i = 0; $i < $count_afdeling_array; $i++) {
                        echo '<option value="' . $afdeling_array[$i]['afdeling_id'] . '">' . $afdeling_array[$i]['afdeling_naam'] . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="object">Object</label>
            </td>
        </tr>
        <tr>
            <td>
                <select name="object" id="object" title="Specifeer hier het object van de storing" required>
                    <option>Maak een keuze</option>
                    <?php
                    for ($i = 0; $i < $count_object_array; $i++) {
                        echo '<option value="' . $object_array[$i]['object_id'] . '">' . $object_array[$i]['object_naam'] . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="titel">Titel</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="titel" id="titel" title="Geef hier de storing een titel" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="beschrijving">Beschrijving</label>
            </td>
        </tr>
        <tr>
            <td>
                <textarea name="beschrijving" id="beschrijving" title="Beschrijf hier de aard van de storing"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" class="knopje" name="Verzenden" value="Aanmaken" />
            </td>
        </tr>
    </table>
</form>