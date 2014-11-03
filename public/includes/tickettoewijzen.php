<?php
$all = get_defined_vars();
//var_dump($all);
include_once 'classes/ticketsysteem.php';
$ticket = new Ticketsysteem;
$ticket_array = $ticket->getTicketArray();
$countArray = count($ticket_array);
?>
<h2>Ticket overzicht</h2>
    <?php

    ?>