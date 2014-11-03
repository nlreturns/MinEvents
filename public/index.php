<?php
include_once 'classes/gebruiker.php';
include_once 'classes/defs/constants.php';
include FILE_CLASS_GEBRUIKERRECHTEN;
include_once FILE_CLASS_LOGIN;
include_once 'classes/RechtConstants.php';
$rechten = new RechtenConstants();
$reflection = new ReflectionClass($rechten);
$recht_array= $reflection->getConstants();
$login = new Login;

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