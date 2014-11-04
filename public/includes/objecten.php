<div id="subnav">
    <div id="halvecirkel">
        <a href="?page=dashboard"><img src="img/home_button.png" /></a>
    </div>
    <ul>
        <li><a href="?page=objecten&subpage=objectoverzicht">Alle objecten</a></li>
        <li><a href="?page=objecten&subpage=objecttoevoegen">Nieuw object</a></li>
    </ul>
</div>

<div class="contentarea">
    <?php
    if(isset($_GET['subpage'])) {
        switch($_GET['subpage']) {
            case "objecttoevoegen": include 'objecttoevoegen.php';
            break;
            case "objectoverzicht": include 'objectoverzicht.php';
            break;
        }
    } else {
    ?>
    <h2>Objecten</h2>
    
    <p>Welkom bij de objectenpagina van M in Events.
    <br />
    <br />
    Links in het menu kunt u kiezen uit: <br />
        - Object toevoegen. Deze optie gebruikt u als u een object wilt toevoegen.<br />
        - Object overzicht. Deze optie gebruikt u als u een overzicht wilt zien van de objecten.
    </p>
</div>
<?php
    }
?>