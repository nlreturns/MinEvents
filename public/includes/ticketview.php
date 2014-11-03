<?php
include_once FILE_TICKETSYSTEEM;
$ticket = new TicketSysteem;
$result = $ticket->getTicket($_GET['id']);
?>
<form>
	<table class="tabel">
		<tr>
			<th><label for="titel">Titel</label></th>
			<td><?php echo $result['ticket_titel']; ?></td>
		</tr
		<tr>
			<th><label for="beschrijving">Beschrijving</label></th>
			<td><?php echo $result['ticket_beschrijving']; ?></td>
		</tr>
		<tr>
			<th><label for="voortgang">Voortgang</label></th>
			<td><?php echo $result['ticket_progress']; ?></td>
		</tr>
		<tr>
			<th><label for="aanmaakt">Aangemaakt op</label></th>
			<td><?php echo $result['ticket_create_tijd']; ?></td>
		</tr>
		<tr>
			<th><label for="beeindigd">Opgelost op</label></th>
			<td><?php echo $result['ticket_end_tijd']; ?></td>
		</tr>
		<tr>
			<th><label for="afdeling">Afdeling</label></th>
			<td><?php echo $result['afdeling_naam']; ?></td>
		</tr>
		<tr>
			<th><label for="object">Object</label></th>
			<td><?php echo $result['object_naam']; ?></td>
		</tr>
	</table>
</form>