<?php
use minevents\app\classes\TicketSysteem as TicketSysteem;

$all = get_defined_vars();
$ticket = new Ticketsysteem;

// SORTING TOTAL TABLE
$sort_by = '';
$direction = '';


//$sort_by = isset($_GET['s']) ? $_GET['s'] : false;
if (isset($_GET['s'])) {
    $sort_by = $_GET['s'];
} else {
    $sort_by = false;
}

switch ($sort_by) {
    case 'titel':
        $sort_by = 'ticket_titel';
        break;
    case 'beschrijving':
        $sort_by = 'ticket_beschrijving';
        break;
    case 'voortgang':
        $sort_by = 'ticket_progress';
        break;
    case 'afdeling':
        $sort_by = 'afdeling_id';
        break;
    case 'object':
        $sort_by = 'object_id';
        break;
    case 'prioriteit':
        $sort_by = 'ticket_prio_id';
        break;
    default:
        $sort_by = 'ticket_end_tijd';
        break;
}

if (isset($_GET['d'])) {
    $direction = $_GET['d'];
} else {
    $direction = false;
}

if ($direction != 'ASC' && $direction != 'DESC') {
    $direction = 'DESC';
}


$ticket_array = $ticket->getTicketArray($sort_by, $direction);

// used in table heading to indicate sort direciton
$sort_arrow = ($direction == 'ASC' ? '<img height="15px" src="img/up.png" />' : '<img height="15px" src="img/down.png" />');

// used to build urls to reverse the current sort direction
$reverse_direction = ($direction == 'DESC' ? 'ASC' : 'DESC');

$countArray = count($ticket_array);

/*
 * check if ticket has to be deleted
 */
if (isset($_GET['delete'])) {
    // maak een instantie van het ticket object
    $ticket = new TicketSysteem();

    $ticket->deleteTicket($_GET['delete']);

    //set message
    echo "<div id='result'>";
    echo 'Uw ticket is <strong>succesvol</strong> verwijderd.!';
    echo "</div>";
}
?>
<!--
     Tabel op de pagina
-->
<h2>Mijn tickets</h2>
<table class="tabel">
    <thead> 
        <tr>
            <th>
                <a class="tabel" href="?page=tickets&subpage=ticketoverzicht&s=titel&d=<?php echo $reverse_direction; ?>#tabs-1">Titel</a>
                <?php echo $sort_by == 'ticket_titel' ? $sort_arrow : ''; ?>
            </th>
            <th>
                <a href="?page=tickets&subpage=ticketoverzicht&s=beschrijving&d=<?php echo $reverse_direction; ?>#tabs-1">Beschrijving</a>
                <?php echo $sort_by == 'ticket_beschrijving' ? $sort_arrow : ''; ?>
            </th>
            <th>
                <a href="?page=tickets&subpage=ticketoverzicht&s=voortgang&d=<?php echo $reverse_direction; ?>#tabs-1">Voortgang</a>
                <?php echo $sort_by == 'ticket_progress' ? $sort_arrow : ''; ?>
            </th>
            <th>
                <a href="?page=tickets&subpage=ticketoverzicht&s=afdeling&d=<?php echo $reverse_direction; ?>#tabs-1">Afdeling</a>
                <?php echo $sort_by == 'afdeling_id' ? $sort_arrow : ''; ?>
            </th>
            <th>
                <a href="?page=tickets&subpage=ticketoverzicht&s=object&d=<?php echo $reverse_direction; ?>#tabs-1">Object</a>
                <?php echo $sort_by == 'object_id' ? $sort_arrow : ''; ?>
            </th>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php
        /**
         * Haalt alle gegevens op
         */
        for ($i = 0; $i < $countArray; $i++) {
            if ($ticket_array[$i]['ticket_status_id'] == 0) {
                if ($ticket_array[$i]['creator_id'] == $_SESSION['user_id']) {

                    echo '<tr>';
                    echo '<td>';
                    echo $ticket_array[$i]['ticket_titel'];
                    echo '</td>';
                    echo '<td>';
                    // shorten the description if longer than 40
                    if (strlen($ticket_array[$i]['ticket_beschrijving']) > 40) {
                        // add link to view page at end
                        $beschrijving = substr($ticket_array[$i]['ticket_beschrijving'], 0, 40) . "..<a href='?page=tickets&subpage=view&id=" . $ticket_array[$i]['ticket_id'] . "'>lees meer</a>";
                    } else {
                        $beschrijving = $ticket_array[$i]['ticket_beschrijving'];
                    }
                    echo $beschrijving;
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
                    echo '<a href="?page=tickets&subpage=view&id=' . $ticket_array[$i]['ticket_id'] . '"><img src="img/view.png" /></a>';
                    echo '<a href="?page=tickets&subpage=ticketwijzigen&id=' . $ticket_array[$i]['ticket_id'] . '"><img src="img/edit_button.png" /></a>';
                    echo '<a href="?page=tickets&subpage=eigentickets&delete=' . $ticket_array[$i]['ticket_id'] . '"><img src="img/cancel_button.png" /></a>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
        }
        /**
         * Haalt alle gegevens op
         */
        for ($i = 0; $i < $countArray; $i++) {
            if ($ticket_array[$i]['ticket_status_id'] == 1 || $ticket_array[$i]['ticket_status_id'] == 2 || $ticket_array[$i]['ticket_status_id'] == 3 || $ticket_array[$i]['ticket_status_id'] == 4) {
                if ($ticket_array[$i]['creator_id'] == $_SESSION['user_id']) {

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
                    echo 'Ticket is toegewezen, aanpassingen niet meer mogelijk';
                    echo '</td>';
                    echo '</tr>';
                }
            }
        }
        if (isset($_POST['id']) && isset($_POST['status'])) {

            $ticket = new TicketSysteem();
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
                $ticket->__set('progress', 'gesloten');
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