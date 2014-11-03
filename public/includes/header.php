<!DOCTYPE html>
<html>
<head>
    <title>M in Events</title>
    <link rel="stylesheet" href="style.css"/>
    <script type="text/javascript" src="js/jquery-2.0.2.js"></script>
</head>
<body>
    <header>
        <span id="logo">
            <a href="?page=dashboard"><img src="img/logo.png"/>
                <h1>M in Events</h1>
            </a>
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
                            <a href="?page=gebruikers">
                                <li>Gebruikers</li>
                            </a>
                            <a href="?page=personen">
                                <li>Personen</li>
                            </a>
                            <a href="?page=afdelingen">
                                <li>Afdelingen</li>
                            </a>
                            <a href="?page=objecten">
                                <li>Objecten</li>
                            </a>
                        </ul>
                    </li>
                    <li><a href="#">FAQ</a></li>
                    <li>
                        <button name="logout">Uitloggen</button>
                    </li>
                </ul>
            </form>
        </nav>
        <h2>Ingelogd als <?php echo $_SESSION['username']; ?></h2>
    </header>