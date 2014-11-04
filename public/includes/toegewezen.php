<?php
use minevents\app\classes\TicketSysteem as TicketSysteem;

$all = get_defined_vars();
$ticket = new Ticketsysteem;
$ticket_array = $ticket->getTicketArray('ticket_end_tijd', 'DESC');
$countArray = count($ticket_array);
?>
           <!--
                Tabel op de pagina
           -->      
<h2>Toegewezen tickets</h2>
<table class="tabel">
    <thead> 
        <tr>
            <th>Titel</th>
            <th>Beschrijving</th>
            <th>Voortgang</th>
            <th>Afdeling</th>
            <th>Object</th>
            <th>Priorteit</th>
            <th>Actie</th>
        </tr>
    </thead>
    <tbody>
        <?php
            /**
             * Haalt alle gegevens op
             */
        for ($i = 0; $i < $countArray; $i++) {
            if ($ticket_array[$i]['ticket_status_id'] == 1) {
                if ($ticket_array[$i]['pers_id'] == $_SESSION['user_id']) {

                    echo '<tr>';
                    echo '<td>';
                    echo $ticket_array[$i]['ticket_titel'];
                    echo '</td>';
                    echo '<td>';
                    echo $ticket_array[$i]['ticket_beschrijving'];
                    echo '</td>';
                    echo '<td>';
                    echo $ticket_array[$i]['ticket_progress'];
                    echo '</td>';
                    echo '<td>';
                    $afdeling = $ticket->getAfdeling($ticket_array[$i]['afdeling_id']);

                    if (isset($afdeling[0]['afdeling_naam'])) {
                        echo $afdeling[0]['afdeling_naam'];
                    }
                    echo '</td>';
                    echo '<td>';

                    $object = $ticket->getObject($ticket_array[$i]['object_id']);

                    if (isset($object[0]['object_naam'])) {
                        echo $object[0]['object_naam'];
                    }
                    echo '</td>';
                    echo '<td>';
                    echo $ticket_array[$i]['ticket_prio_id'];
                    echo '</td>';
                    echo '<td>';
                    echo '<form name="afvinken" method="POST"><input type="hidden" name="id" value="' . $ticket_array[$i]['ticket_id'] . '"><input type="hidden" name="status" value="' . $ticket_array[$i]['ticket_status_id'] . '"><input type="image" src="img/check.png" /></form>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
        }
            
        if (isset($_POST['id']) && isset($_POST['status'])) {
            $current = $ticket->getTicketByID($_POST['id']);
            $ticket->__set('pers_id', $current['pers_id']);
            $ticket->__set('titel', $current['ticket_titel']);
            $ticket->__set('afdeling', $current['afdeling_id']);
            $ticket->__set('object', $current['object_id']);
            $ticket->__set('beschrijving', $current['ticket_beschrijving']);
            $ticket->__set('prioid', $current['ticket_prio_id']);
            $ticket->__set('ticket_end_tijd', $current['ticket_end_tijd']);

            if ($_POST['status'] == 2) {
                $ticket->__set('progress', 'In behandeling');
                $ticket->__set('ticket_status_id', 1);
            } else {
                $ticket->__set('progress', 'Verholpen');
                $ticket->__set('ticket_status_id', 2);
            }
            $ticket->updateTicket();
            /**
             * Ticket opslaan in database
             */
            echo "<div id='result'>";
            echo 'Uw ticket is <strong>succesvol</strong> verwerkt!';
            echo "</div>";
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
        ?>
    </tbody>
</table>