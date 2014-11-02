<div id="subnav">
    <div id="halvecirkel">
        <a href="?page=dashboard"><img src="img/home_button.png" /></a>
    </div>
    <ul>
        <?php if (!$gebruiker->heeftRecht($_SESSION['gebruiker_recht'], $recht_array['RIGHT_VIEW_USER'])) { ?>
            <li><a href="?page=gebruikers&subpage=gebruikeroverzicht">Alle gebruikers</a></li>
        <?php } ?>
        <li><a href="?page=gebruikers&subpage=nieuwegebruiker">Nieuwe gebruiker</a></li>
    </ul>
</div>

<div class="contentarea">
    <?php
    if (isset($_GET['subpage'])) {
        switch ($_GET['subpage']) {
            case "gebruikeroverzicht": include 'gebruikeroverzicht.php';
                break;
            case "nieuwegebruiker": include 'nieuwegebruiker.php';
                break;
            case "gebruikerview": include 'userview.php';
                break;
        }
    } else {
        ?>
        <h2>Gebruikers</h2>

        <p>Welkom bij het gebruikersysteem van M in Events.
            <br />
            <br />
            Links in het menu kunt u kiezen uit: <br />
            - Alle gebruikers. Deze optie gebruikt u als u alle gebruikers wilt zien van het systeem.<br />
            - Nieuwe gebruiker. Deze optie gebruikt u als u een gebruiker wilt toevoegen.<br />
        </p>
    </div>
    <?php
}
?>