<?php 
?>
<div id="subnav">
    <div id="halvecirkel">
        <a href="?page=dashboard"><img src="img/home_button.png" /></a>
    </div>
    <ul style="margin-left: 39px;">
        <li><a href="?page=tickets&subpage=ticketformulier">Ticketformulier</a></li>
        <?php
        if(!$gebruiker->heeftRecht($_SESSION['gebruiker_recht'], $recht_array['RIGHT_TICKET_OVERVIEW'])){
        ?>
        <li><a href="?page=tickets&subpage=ticketoverzicht">Ticketoverzicht</a></li>
        <?php } ?>
        <li><a href="?page=tickets&subpage=toegewezentickets">Toegewezen tickets</a></li>
        <li><a href="?page=tickets&subpage=eigentickets">Eigen tickets</a></li>
    </ul>
</div>

<div class="contentarea">
    <?php
    if (isset($_GET['subpage'])) {
        switch ($_GET['subpage']) {
            case "ticketformulier": include 'ticketformulier.php';
                break;
            case "ticketoverzicht": include 'ticketoverzicht.php';
                break;
            case "tickettoewijzen": include 'tickettoewijzen.php';
                break;
            case "eigentickets": include 'eigentickets.php';
                break;
            case "toegewezentickets": include 'toegewezen.php';
                break;
            case "gebruiker": include 'gebruikerformulier.php';
                break;
            case "persoon": include 'persoonformulier.php';
                break;
            case "ticketwijzigen": include 'ticketwijzigen.php';
                break;
            case "view": include 'ticketview.php';
                break;
        }
    } else {
        ?>
        <h2>Ticketsysteem</h2>

        <p>Welkom bij het ticketsysteem van M in Events.
            <br />
            <br />
            Links in het menu kunt u kiezen uit: <br />
            - Ticketformulier. Deze optie gebruikt u als u een ticket wilt invoeren.<br />
            - Ticketoverzicht. Deze optie gebruikt u als u het totaal aantal tickets wilt bekijken.<br />
            - Toegewezen tickets. Deze optie gebruikt u om de te bekijken welke tickets er aan u zijn toegewezen.<br />
            - Eigen tickets. Deze optie gebruikt u als u alleen uw eigen verzonden tickets wilt bekijken.
        </p>
    </div>
    <?php
}
?>