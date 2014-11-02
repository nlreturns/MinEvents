<?php
include_once FILE_TICKETSYSTEEM;
include_once FILE_AFDELING;
include_once FILE_GEBRUIKER;

if (isset($_POST['Verzenden'])) {
    $ticket = new TicketSysteem();
    /**
     * Nieuwe instantie van ticketsysteem maken.
     * Alles setten.
     */
    // get ticket by id
    $current = $ticket->getTicketByID($_POST['id']);

    $ticket->__set('ticket_id', $_POST['id']);
    $ticket->__set('pers_id', $_POST['gebruiker']);
    $ticket->__set('titel', $current['ticket_titel']);
    $ticket->__set('afdeling', $current['afdeling_id']);
    $ticket->__set('object', $current['object_id']);
    $ticket->__set('beschrijving', $current['ticket_beschrijving']);
    $ticket->__set('progress', 'In behandeling');
    if (isset($_POST['priod_id'])) {
        $ticket->__set('prioid', $_POST['prio_id']);
    } else {
        $ticket->__set('prioid', $current['ticket_prio_id']);
    }
    $ticket->__set('ticket_status_id', '1');
    $ticket->__set('ticket_end_tijd', $current['ticket_end_tijd']);
    $ticket->updateTicket();
    /**
     * Ticket opslaan in database
     */
    echo "<div id='result'>";
    echo 'Uw ticket is <strong>succesvol</strong> toegewezen!<button style="font-size:15px; color:blue;"  id="button">x</button>';
    echo "</div>";
}

/*
 * check if ticket has to be deleted
 */
if (isset($_GET['delete'])) {
    // maak een instantie van het ticket object
    $ticket = new TicketSysteem();

    // delete ticket
    $ticket->deleteTicket($_GET['delete']);

    //set message
    echo "<div id='result'>";
    echo 'Uw ticket is <strong>succesvol</strong> verwijderd!<button style="font-size:15px; color:blue;"  id="button">x</button>';
    echo "</div>";
}

/*
 * check if ticket has to be returned
 */
if (isset($_GET['return'])) {
    // maak een instantie van het ticket object
    $ticket = new TicketSysteem();

    $current = $ticket->getTicketByID($_GET['return']);
// Zend ticket terug naar in behandeling
    $ticket->__set('ticket_id', $_GET['return']);
    $ticket->__set('pers_id', $current['pers_id']);
    $ticket->__set('titel', $current['ticket_titel']);
    $ticket->__set('afdeling', $current['afdeling_id']);
    $ticket->__set('object', $current['object_id']);
    $ticket->__set('beschrijving', $current['ticket_beschrijving']);
    $ticket->__set('progress', 'In behandeling');
    $ticket->__set('prioid', $current['ticket_prio_id']);
    $ticket->__set('ticket_status_id', '1');
    $ticket->__set('ticket_end_tijd', $current['ticket_end_tijd']);
    $ticket->updateTicket();

    //Ticket staat terug in behandeling




    echo "<div id='result'>";
    echo 'Uw ticket is <strong>succesvol</strong> teruggestuurd!<button style="font-size:15px; color:blue;"  id="button">x</button>';
    echo "</div>";
}

/* update tickets tab 3 & 4 */
if (isset($_POST['id']) && isset($_POST['status'])) {

    $ticket = new TicketSysteem();
    $current = $ticket->getTicketByID($_POST['id']);
    $ticket->__set('ticket_id', $_POST['id']);
    $ticket->__set('pers_id', $current['pers_id']);
    $ticket->__set('titel', $current['ticket_titel']);
    $ticket->__set('afdeling', $current['afdeling_id']);
    $ticket->__set('object', $current['object_id']);
    $ticket->__set('beschrijving', $current['ticket_beschrijving']);
    $ticket->__set('prioid', $current['ticket_prio_id']);
    $ticket->__set('ticket_end_tijd', $current['ticket_end_tijd']);

    if ($_POST['status'] == 3) {
        $ticket->__set('progress', 'Verholpen');
        $ticket->__set('ticket_status_id', 2);
    } else {
        $ticket->__set('progress', 'Afgerond');
        $ticket->__set('ticket_status_id', 3);
        $now = date('Y-m-d G:i:s');
        $ticket->__set('ticket_end_tijd', $now);
    }
    $ticket->updateTicket();
    /**
     * Ticket opslaan in database
     */
    echo "<div id='result'>";
    echo 'Uw ticket is <strong>succesvol</strong> verwerkt!<button style="font-size:15px; color:blue;"  id="button">x</button>';
    echo "</div>";
}

$ticket = new Ticketsysteem;
$afdeling = new Afdeling();
$gebruiker = new Gebruiker(new DbGebruiker());

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


$afdeling_array = $afdeling->getList();
$gebruiker_array = $gebruiker->getGebruikerList();

$count_gebruiker_array = count($gebruiker_array);
$countArray = count($ticket_array);
$count_afdeling_array = count($afdeling_array);
?>
<link rel="stylesheet" href="js/jquery-ui.css">
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
    $(function() {
        $('#tabs').tabs({
            activate: function(event, ui) {
                (location.hash != "") ? location.hash.replace("#", "") : 0;
                // Verandere url naar id van geselecteerd object (location.hash)
                //var active = $("#tabs").tabs("option", "active");
                

                // Store
                localStorage.setItem("tab", $("#tabs").tabs("option", "active"));
                // Retrieve
                var active = localStorage.getItem("tab");
                
                location.hash = $("#tabs ul>li a").eq(active).attr('href');

            }
        });
    });
</script>
<script>
    // close button for notifications
    $('#button').click(function(sluitknop) {
        sluitknop.preventDefault(); //to prevent standard click event
        $('#result').toggle();
    });
</script>
<script>
    $(function() {
        $("#tabs").tabs();
    });
</script>

<h2>Ticket overzicht</h2>
<div id="tabs" style="position: inherit; padding:30px;">
    <ul>
        <li><a href="#tabs-1">Niet toegewezen</a></li>
        <li><a href="#tabs-2">In behandeling</a></li>
        <li><a href="#tabs-3">Verholpen</a></li>
        <li><a href="#tabs-4">Totaal</a></li>
    </ul>
    <div id="tabs-1">
        <!-- Niet toegewezen taken -->
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
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=prioriteit&d=<?php echo $reverse_direction; ?>#tabs-1">Priorteit</a>
                        <?php echo $sort_by == 'ticket_prio_id' ? $sort_arrow : ''; ?>
                    </th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // loop all
                for ($i = 0; $i < $countArray; $i++) {
                    // filter on not-assigned
                    if ($ticket_array[$i]['pers_id'] == 0) {
                        // show information
                        echo '<form method="post" name="form1" id="ticketverwijzen" action="#">';
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
                        ?>
                    <select name="prio_id" id="prio_id" title="Prioriteit aangeven" required>
                        <?php
                        for ($amount = 0; $amount < 4; $amount++) {
                            if ($ticket_array[$i]['ticket_prio_id'] == $amount) {
                                echo '<option selected value="' . $amount . '">' . $amount . '</option></center>';
                            } else {
                                echo '<option value="' . $amount . '">' . $amount . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <?php
                    echo '</td>';
                    echo '<td>';
                    echo '<a href="?page=tickets&subpage=view&id=' . $ticket_array[$i]['ticket_id'] . '"><img src="img/view.png" /></a>';
                    echo '<a href="?page=tickets&subpage=ticketwijzigen&id=' . $ticket_array[$i]['ticket_id'] . '"><img src="img/edit_button.png" /></a>';
                    echo '<a href="?page=tickets&subpage=ticketoverzicht&delete=' . $ticket_array[$i]['ticket_id'] . '"><img src="img/cancel_button.png" /></a>';
                    ?>
                    <select name="gebruiker" id="gebruiker" title="Kies hier de gebruiker die dit ticket moet afhandelen" required>
                        <option>Maak een keuze</option>
                        <?php
                        for ($a = 0; $a < $count_gebruiker_array; $a++) {
                            if ($gebruiker_array[$a]['gebruiker_id'] == $ticket_array[$i]['pers_id']) {
                                echo '<option selected value="' . $gebruiker_array[$a]['gebruiker_id'] . '">' . $gebruiker_array[$a]['gebruiker_naam'] . '</option>';
                            } else {
                                echo '<option value="' . $gebruiker_array[$a]['gebruiker_id'] . '">' . $gebruiker_array[$a]['gebruiker_naam'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <?php
                    echo '<br />';
                    echo '<input type="hidden" name="id" value="' . $ticket_array[$i]['ticket_id'] . '">';
                    echo '<input type="submit" class="knopje" name="Verzenden" value="Toewijzen" />';
                    echo '</td>';
                    echo '</tr>';
                    echo '</form>';
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <div id="tabs-2">
        <!-- Taken in behandeling -->
        <table class="tabel">
            <thead> 
                <tr>
                    <th>
                        <a class="tabel" href="?page=tickets&subpage=ticketoverzicht&s=titel&d=<?php echo $reverse_direction; ?>#tabs-2">Titel</a>
                        <?php echo $sort_by == 'ticket_titel' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=beschrijving&d=<?php echo $reverse_direction; ?>#tabs-2">Beschrijving</a>
                        <?php echo $sort_by == 'ticket_beschrijving' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=voortgang&d=<?php echo $reverse_direction; ?>#tabs-2">Voortgang</a>
                        <?php echo $sort_by == 'ticket_progress' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=afdeling&d=<?php echo $reverse_direction; ?>#tabs-2">Afdeling</a>
                        <?php echo $sort_by == 'afdeling_id' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=object&d=<?php echo $reverse_direction; ?>#tabs-2">Object</a>
                        <?php echo $sort_by == 'object_id' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=prioriteit&d=<?php echo $reverse_direction; ?>#tabs-2">Priorteit</a>
                        <?php echo $sort_by == 'ticket_prio_id' ? $sort_arrow : ''; ?>
                    </th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // loop all
                for ($i = 0; $i < $countArray; $i++) {
                    // filter on status = assigned
                    if ($ticket_array[$i]['ticket_status_id'] == 1) {
                        // show information
                        echo '<form method="post" name="form1" id="ticketverwijzen" action="#tabs-2">';
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
                        echo $ticket_array[$i]['ticket_prio_id'];
                        echo '</td>';
                        echo '<td>';
                        echo '<a href="?page=tickets&subpage=view&id=' . $ticket_array[$i]['ticket_id'] . '"><img src="img/view.png" /></a>';
                        echo '<a href="?page=tickets&subpage=ticketwijzigen&id=' . $ticket_array[$i]['ticket_id'] . '"><img src="img/edit_button.png" /></a>';
                        ?>
                    <select name="gebruiker" id="gebruiker" title="Kies hier de gebruiker die dit ticket moet afhandelen" required>
                        <option>Maak een keuze</option>
                        <?php
                        for ($a = 0; $a < $count_gebruiker_array; $a++) {
                            if ($gebruiker_array[$a]['gebruiker_id'] == $ticket_array[$i]['pers_id']) {
                                echo '<option selected value="' . $gebruiker_array[$a]['gebruiker_id'] . '">' . $gebruiker_array[$a]['gebruiker_naam'] . '</option>';
                            } else {
                                echo '<option value="' . $gebruiker_array[$a]['gebruiker_id'] . '">' . $gebruiker_array[$a]['gebruiker_naam'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <?php
                    echo '<br />';
                    echo '<input type="hidden" name="id" value="' . $ticket_array[$i]['ticket_id'] . '">';
                    echo '<input type="submit" class="knopje" name="Verzenden" value="Toewijzen" />';
                    echo '</td>';
                    echo '</tr>';
                    echo '</form>';
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <div id="tabs-3">
        <!-- Afgeronde taken -->
        <table class="tabel">
            <thead> 
                <tr>
                    <th>
                        <a class="tabel" href="?page=tickets&subpage=ticketoverzicht&s=titel&d=<?php echo $reverse_direction; ?>#tabs-3">Titel</a>
                        <?php echo $sort_by == 'ticket_titel' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=beschrijving&d=<?php echo $reverse_direction; ?>#tabs-3">Beschrijving</a>
                        <?php echo $sort_by == 'ticket_beschrijving' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=voortgang&d=<?php echo $reverse_direction; ?>#tabs-3">Voortgang</a>
                        <?php echo $sort_by == 'ticket_progress' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=afdeling&d=<?php echo $reverse_direction; ?>#tabs-3">Afdeling</a>
                        <?php echo $sort_by == 'afdeling_id' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=object&d=<?php echo $reverse_direction; ?>#tabs-3">Object</a>
                        <?php echo $sort_by == 'object_id' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=prioriteit&d=<?php echo $reverse_direction; ?>#tabs-3">Priorteit</a>
                        <?php echo $sort_by == 'ticket_prio_id' ? $sort_arrow : ''; ?>
                    </th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // loop all
                for ($i = 0; $i < $countArray; $i++) {
                    // filter on status = verholpen
                    if ($ticket_array[$i]['ticket_status_id'] == 2) {
                        // show information
                        echo '<form method="post" name="form1" id="ticketverwijzen" action="#">';
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
                        echo $ticket_array[$i]['ticket_prio_id'];
                        echo '</td>';
                        echo '<td>';
                        echo '<a href="?page=tickets&subpage=ticketoverzicht&return=' . $ticket_array[$i]['ticket_id'] . '#tabs-3"><img src="img/return_button.png" /></a>';
                        echo '<a href="?page=tickets&subpage=view&id=' . $ticket_array[$i]['ticket_id'] . '"><img src="img/view.png" /></a>';
                        echo '<a href="?page=tickets&subpage=ticketwijzigen&id=' . $ticket_array[$i]['ticket_id'] . '"><img src="img/edit_button.png" /></a>';
                        echo '<input style="vertical-align: baseline" type="image" src="img/check.png" />';
                        echo '<input type="hidden" name="id" value="' . $ticket_array[$i]['ticket_id'] . '"><input type="hidden" name="status" value="' . $ticket_array[$i]['ticket_status_id'] . '">';
                        ?>
                    <select name="gebruiker" id="gebruiker" title="Kies hier de gebruiker die dit ticket moet afhandelen" required>
                        <option>Maak een keuze</option>
                        <?php
                        for ($a = 0; $a < $count_gebruiker_array; $a++) {
                            if ($gebruiker_array[$a]['gebruiker_id'] == $ticket_array[$i]['pers_id']) {
                                echo '<option selected value="' . $gebruiker_array[$a]['gebruiker_id'] . '">' . $gebruiker_array[$a]['gebruiker_naam'] . '</option>';
                            } else {
                                echo '<option value="' . $gebruiker_array[$a]['gebruiker_id'] . '">' . $gebruiker_array[$a]['gebruiker_naam'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <?php
                    echo '<br />';
                    echo '<input type="hidden" name="id" value="' . $ticket_array[$i]['ticket_id'] . '">';
                    echo '<input type="submit" class="knopje" name="Verzenden" value="Toewijzen" />';
                    echo '</td>';
                    echo '</tr>';
                    echo '</form>';
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <div id="tabs-4">
        <!-- Totaal -->
        <table class="tabel">
            <thead> 
                <tr>
                    <th>
                        <a class="tabel" href="?page=tickets&subpage=ticketoverzicht&s=titel&d=<?php echo $reverse_direction; ?>#tabs-4">Titel</a>
                        <?php echo $sort_by == 'ticket_titel' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=beschrijving&d=<?php echo $reverse_direction; ?>#tabs-4">Beschrijving</a>
                        <?php echo $sort_by == 'ticket_beschrijving' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=voortgang&d=<?php echo $reverse_direction; ?>#tabs-4">Voortgang</a>
                        <?php echo $sort_by == 'ticket_progress' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=afdeling&d=<?php echo $reverse_direction; ?>#tabs-4">Afdeling</a>
                        <?php echo $sort_by == 'afdeling_id' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=object&d=<?php echo $reverse_direction; ?>#tabs-4">Object</a>
                        <?php echo $sort_by == 'object_id' ? $sort_arrow : ''; ?>
                    </th>
                    <th>
                        <a href="?page=tickets&subpage=ticketoverzicht&s=prioriteit&d=<?php echo $reverse_direction; ?>#tabs-4">Priorteit</a>
                        <?php echo $sort_by == 'ticket_prio_id' ? $sort_arrow : ''; ?>
                    </th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < $countArray; $i++) {
                    echo '<form method="post" name="form1" id="ticketverwijzen" action="#">';
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
                    // $object->getAfdeling($object_array[$i]['afdeling_id']);
                    if (isset($afdeling[0]['afdeling_naam'])) {
                        echo $afdeling[0]['afdeling_naam'];
                    }
                    echo '</td>';
                    echo '<td>';
                    //var_dump($ticket->getObject($ticket_array[$i]['object_id']));
                    $object = $ticket->getObject($ticket_array[$i]['object_id']);
                    // $object->getAfdeling($object_array[$i]['afdeling_id']);
                    if (isset($object[0]['object_naam'])) {
                        echo $object[0]['object_naam'];
                    }
                    echo '</td>';
                    echo '<td>';
                    echo $ticket_array[$i]['ticket_prio_id'];
                    echo '</td>';
                    echo '<td>';
                    echo '<a href="?page=tickets&subpage=view&id=' . $ticket_array[$i]['ticket_id'] . '"><img src="img/view.png" /></a>';
                    echo '<a href="?page=tickets&subpage=ticketwijzigen&id=' . $ticket_array[$i]['ticket_id'] . '"><img src="img/edit_button.png" /></a>';
                    echo '<input style="vertical-align: baseline; font-size: 1.1em" type="image" src="img/cancel_button.png" />';
                    echo '<form name="afvinken" method="POST" action="#"><input type="hidden" name="id" value="' . $ticket_array[$i]['ticket_id'] . '"><input type="hidden" name="status" value="' . $ticket_array[$i]['ticket_status_id'] . '"></form>';
                    echo '<br />';
                    echo '<div style="width: 200px">';
                    for ($a = 0; $a < $count_gebruiker_array; $a++) {
                        if ($gebruiker_array[$a]['gebruiker_id'] == $ticket_array[$i]['pers_id']) {
                            echo $gebruiker_array[$a]['gebruiker_naam'];
                        }
                    }
                    echo '</div>';
                    echo '</td>';
                    echo '</tr>';
                    echo '</form>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>