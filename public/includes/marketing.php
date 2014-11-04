<div id="subnav">
    <div id="halvecirkel">
        <a href="?page=dashboard"><img src="img/home_button.png" /></a>
    </div>
    <ul>
        <li><a href="?page=marketing&subpage=klantaanmaken">Klant aanmaken</a></li>
        <li><a href="?page=marketing&subpage=klantbewerken">Klant bewerken</a></li>
        <li><a href="?page=marketing&subpage=klantenoverzicht">Klanten overzicht</a></li>
    </ul>
</div>

<div class="contentarea">
    <?php
    if(isset($_GET['subpage'])) {
        switch($_GET['subpage']) {
            case "klantaanmaken": include 'klantaanmaken.php';
            break;
            case "klantbewerken": include 'klantbewerken.php';
            break;
            case "klantenoverzicht": include 'klantenoverzicht.php';
            break;
            }
        } else {
        ?>
    <h2>Marketing</h2>
    
    <p>Welkom bij het Marketingsysteem van Mi n Events. 
    <br />
    <br />
    Links in het menu kunt u kiezen uit: <br />
    - Klant aanmaken. Hier kunt u een nieuwe klant klant aanmaken.<br />
    - Klant bewerken. Met deze optie kunt u klanten informatie bewerken of verwijderen.<br />
    - Klant overzicht. Deze optie gebruikt u als u een overzicht van alle klanten wilt bekijken.
    </p>
</div>
<?php
    }
?>