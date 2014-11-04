<div id="subnav">
    <div id="halvecirkel">
        <a href="?page=dashboard"><img src="img/home_button.png" /></a>
    </div>
    <ul>
    </ul>
</div>

<div class="contentarea">
    <?php
    if(isset($_GET['subpage'])) {
        switch($_GET['subpage']) {
            case "ticketformulier": include 'ticketformulier.php';
            break;
            case "ticketoverzicht": include 'ticketoverzicht.php';
            break;
            case "eigentickets": include 'eigentickets.php';
            break;
            }
        } else {
        ?>
    <h2>Personeel</h2>
    
    <p>
    </p>
</div>
<?php
    }
?>