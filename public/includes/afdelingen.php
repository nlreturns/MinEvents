<div id="subnav">
    <div id="halvecirkel">
        <a href="?page=dashboard"><img src="img/home_button.png" /></a>
    </div>
    <ul>
        <li><a href="?page=afdelingen&subpage=afdelingoverzicht">Alle afdelingen</a></li>
        <li><a href="?page=afdelingen&subpage=afdelingtoevoegen">Nieuwe afdeling</a></li>
    </ul>
</div>

<div class="contentarea">
    <?php
    if (isset($_GET['subpage'])) {
        switch ($_GET['subpage']) {
            case "afdelingtoevoegen": include_once 'afdelingtoevoegen.php';
                break;
            case "afdelingoverzicht": include_once 'afdelingoverzicht.php';
                break;
        }
    } else {
        ?>
        <h2>Afdelingen</h2>

        <p>Welkom bij het afdelingsysteem van M in Events.
            <br />
            <br />
            Links in het menu kunt u kiezen uit: <br />
            - Afdeling toevoegen. Deze optie gebruikt u als u een afdeling wilt toevoegen.<br />
            - Afdeling overzicht. Deze optie gebruikt u als u een overzicht wilt zien van de afdelingen.<br />

        </p>
    </div>
    <?php
}
?>