<?php
include_once '../app/core/SplClassLoader.php';
include_once '../app/config/constants.php';
include_once '../app/config/db_constants.php';
$autoloader = new \minevents\app\core\SplClassLoader('minevents\app', '../../');
$autoloader->register();

use minevents\app\classes\RechtenConstants as RechtenConstants;
use minevents\app\classes\Loginsysteem as Loginsysteem;
use minevents\app\classes\Gebruiker as Gebruiker;
use minevents\app\classes\db\DbGebruiker as DbGebruiker;
use minevents\app\classes\GebruikerRecht as GebruikerRecht;


$rechten = new RechtenConstants();
$reflection = new ReflectionClass($rechten);
$recht_array= $reflection->getConstants();
$login = new Loginsysteem();
$gebruiker = new Gebruiker(new DbGebruiker());

if (!$login->isloggedin()) {
    header("Location: login_scherm.php");
    exit;
} else {
    $recht = new GebruikerRecht();
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>M in Events</title>
            <link rel="stylesheet" href="style.css" />
            <script type="text/javascript" src="js/jquery-2.0.2.js">
            </script>
        </head>
        <body>
            <header>
                <span id="logo">
                    <a href="?page=dashboard"><img src="img/logo.png"/>

                        <h1>M in Events</h1></a>
                </span>
                <nav>
                    <?php
                    if (isset($_POST['logout'])) {
                        $login->logout();
                        header("Location: login_scherm.php");
                        exit;
                    }
                    ?>
                    <form method="POST" id="logout" name="logout">
                        <ul>
                            <li><a href="#">Instellingen</a>
                                <ul>
                                    <a href="?page=gebruikers"><li>Gebruikers</li></a>
                                    <a href="?page=personen"><li>Personen</li></a>
                                    <a href="?page=afdelingen"><li>Afdelingen</li></a>
                                    <a href="?page=objecten"><li>Objecten</li></a>
                                </ul>
                            </li>
                            <li><a href="#">FAQ</a></li>            
                            <li><button name="logout">Uitloggen</button></li>
                        </ul>
                    </form>
                </nav>
                <h2>Ingelogd als <?php echo $_SESSION['username']; ?></h2>
            </header>

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

            <footer>
                <p>Realisatie: Stichting Innovision Solutions</p>
            </footer>
        </body>
    </html>
    <?php
}
?>