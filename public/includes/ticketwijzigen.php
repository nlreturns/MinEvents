<?php
use minevents\app\classes\TicketSysteem as TicketSysteem;
use minevents\app\classes\Afdeling as Afdeling;
use minevents\app\classes\Prioriteit as Prioriteit;
use minevents\app\classes\Object as Object;

$object = new Object();
$afdeling = new Afdeling();
$prioriteit = new Prioriteit();

$object_array = $object->getList();
$afdeling_array = $afdeling->getList();
$prioriteit_array = $prioriteit->getList();

$count_prioriteit_array = count($prioriteit_array);
$count_afdeling_array = count($afdeling_array);
$count_object_array = count($object_array);
$ticket = new TicketSysteem();
$this_ticket = $ticket->getTicketByID($_GET['id']);
$result = mysql_query("SELECT * FROM ticketsysteem")
        or die(mysql_error());
$row = mysql_fetch_array($result);

if (isset($_POST['wijziging_opslaan'])) {
    /**
     * Nieuwe instantie van ticketsysteem maken.
     * Alles setten.
     */
    $ticket->__set('titel', $_POST['titel']);
    $ticket->__set('afdeling', $_POST['afdeling']);
    $ticket->__set('object', $_POST['object']);
    $ticket->__set('beschrijving', $_POST['beschrijving']);
    $ticket->__set('progress', $this_ticket['ticket_progress']);
    $ticket->__set('prioid', $_POST['prioriteit']);
    $ticket->__set('pers_id',$this_ticket['pers_id']);
    $ticket->__set('ticket_status_id',$this_ticket['ticket_status_id']);
    $ticket->__set('ticket_end_tijd',$this_ticket['ticket_end_tijd']);
    /**
     * Ticket opslaan in database
     */
    $ticket->updateTicket();

    echo "<div id='result'>";
    echo 'Uw ticket is <strong>succesvol</strong> gewijzigd!';
    echo "</div>";
} else {
?>
<form method="post" name="form1" id="ticketform" action="#">
    <h2>Ticket wijzigen</h2>
    <table class="formulier">
        <tr>
            <td>
                <label for="afdeling">Afdeling</label>
            </td>
        </tr>
        
        <tr>
            <td>
                <select value="<?php echo $this_ticket['afdeling_id']; ?>" name="afdeling" id="afdeling" title="Kies hier de afdeling waar de storing zich voordoet" required>
                    <option>Maak een keuze</option>
                    <?php
                    for ($i = 0; $i < $count_afdeling_array; $i++) {
                        if ($afdeling_array[$i]['afdeling_id'] == $this_ticket['afdeling_id']) {
                            echo '<option selected value="' . $afdeling_array[$i]['afdeling_id'] . '">' . $afdeling_array[$i]['afdeling_naam'] . '</option>';
                        } else {
                            echo '<option value="' . $afdeling_array[$i]['afdeling_id'] . '">' . $afdeling_array[$i]['afdeling_naam'] . '</option>';
                        }
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
                <select value="<?php echo $this_ticket['object_id']; ?>" name="object" id="object" title="Specifeer hier het object van de storing" required>
                    <option>Maak een keuze</option>
                    <?php
                    for ($i = 0; $i < $count_object_array; $i++) {
                        if ($object_array[$i]['object_id'] == $this_ticket['object_id']) {
                            echo '<option selected value="' . $object_array[$i]['object_id'] . '">' . $object_array[$i]['object_naam'] . '</option>';
                        } else {
                            echo '<option value="' . $object_array[$i]['object_id'] . '">' . $object_array[$i]['object_naam'] . '</option>';
                        }
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
                <input value="<?php echo $this_ticket['ticket_titel']; ?>" type="text" name="titel" id="titel" title="Geef hier de storing een titel" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="beschrijving">Beschrijving</label>
            </td>
        </tr>
        <tr>
            <td>
                <textarea name="beschrijving" id="beschrijving" title="Beschrijf hier de aard van de storing"><?php echo $this_ticket['ticket_beschrijving']; ?></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <label for="prioriteit">Prioriteit</label>
            </td>
        </tr>
        <tr>
            <td>
                <select value="<?php echo $this_ticket['ticket_prio_id']; ?>" name="prioriteit" id="prioriteit" title="Selecteer hoe hoog de prioriteit is" required>
                    <option>Maak een keuze</option>
                    <?php
                    for ($i = 0; $i < $count_prioriteit_array; $i++) {
                        if ($prioriteit_array[$i]['ticket_prio_id'] == $this_ticket['ticket_prio_id']) {
                            echo '<option selected value="' . $prioriteit_array[$i]['ticket_prio_id'] . '">' . $prioriteit_array[$i]['ticket_prio_label'] . '</option>';
                        } else {
                            echo '<option value="' . $prioriteit_array[$i]['ticket_prio_id'] . '">' . $prioriteit_array[$i]['ticket_prio_label'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" class="knopje" name="wijziging_opslaan" value="Wijzigingen opslaan" />
            </td>
        </tr>
    </table>
</form>
<?php
}
?>