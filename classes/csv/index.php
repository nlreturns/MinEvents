<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="afbeeldingen/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="afbeeldingen/favicon.ico" type="image/x-icon" />
<link rel="favicon" href="afbeeldingen/favicon.ico" type="image/x-icon" />

<link href="style.css" rel="stylesheet" type="text/css"/>
<title>Csv bestand inladen</title>
</head>

<body>
<div id="wrapper_background">
    <div id="wrapper">
        <div id="header_wrapper">
            <div id="header_left">
                <div class="titlepush"></div>
                <font class="title">Adressen inladen</font></div>
            <div id="header_wrapper_right">
                <div id="header_menu">
                    <div id="topmenu1"><a href="index.html" class="topmenu"></a></div>
                    <div id="topmenu2"><a href="index.html" class="topmenu"></a></div>
                    <div id="topmenu3"><a href="index.html" class="topmenu"></a></div>
                </div>
                <div id="header_status">
                    <div class="login">Ingelogd als:</div><div class="naam">Mario Spetic</div>
                </div>
            </div>
        </div>
        <div id="content_main_wrapper">
            <div id="sidebar_wrapper">
                <div id="sidebar_left">
                	<div id="homeknop"><a href="../../../" class="homebutton"></a></div>
                </div>
                    <div id="sidebar_menu">
                    <div id="menu2"><a href="index.php" class="menu">CSV inladen</a></div>
                    <div id="menu3"><a href="help.html" class="menu">Help</a></div>

                </div>
            </div>
            <div id="content_wrapper">
                <div id="content_subemenu"><h class="content_header">CSV Bestand inladen</h></div>
                <div id="content">
				<p>
				Selecteer je csv bestand om de gegevens in de database te zetten.
				</p>
					<?php include 'import.php'; ?>
                </div>
            </div>
        </div>
        <div id="footer">Realisatie: Stichting Innovision Solutions</div>
    </div>
</div>
</body>

</html>
