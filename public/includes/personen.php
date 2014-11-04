<div id="subnav">
    <div id="halvecirkel">
        <a href="?page=dashboard"><img src="img/home_button.png" /></a>
    </div>
    <ul>
        <li><a href="?page=personen&subpage=persoonoverzicht">Alle personen</a></li>
        <li><a href="?page=personen&subpage=nieuwpersoon">Nieuw persoon</a></li>
    </ul>
</div>

<div class="contentarea">
    <?php
    if(isset($_GET['subpage'])) {
        switch($_GET['subpage']) {
            case "persoonoverzicht": include 'personenoverzicht.php';
            break;
            case "nieuwpersoon": include 'nieuwpersoon.php';
            break;
            }
        } else {
        ?>
    <h2>Personen</h2>
    
    <p>Welkom bij het personensysteem van M in Events.
    <br />
    <br />
    Links in het menu kunt u kiezen uit: <br />
    - Alle personen. Deze optie gebruikt u als u alle personen wilt zien van het systeem.<br />
    - Nieuw persoon. Deze optie gebruikt u als u een persoon wilt toevoegen.<br />
    </p>
</div>
<?php
    }
?>