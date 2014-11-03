<div id="content">
    <?php
    if (isset($_GET['page'])) {
        switch ($_GET['page']) {
            case "dashboard":
                include 'includes/dashboard.php';
                break;
            case "nieuwsbrief":
                include 'includes/nieuwsbrief.php';
                break;
            case "personeel":
                include 'includes/personeel.php';
                break;
            case "tickets":
                include 'includes/tickets.php';
                break;
            case "rooster":
                include 'includes/rooster.php';
                break;
            case "marketing":
                include 'includes/marketing.php';
                break;
            case "gebruikers":
                include 'includes/gebruikers.php';
                break;
            case "personen":
                include 'includes/personen.php';
                break;
            case "afdelingen":
                include 'includes/afdelingen.php';
                break;
            case "objecten":
                include 'includes/objecten.php';
                break;
        }
    } else {
        include 'includes/dashboard.php';
    }
    ?>
</div>