<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>M in Events | Rechtgroep toevoegen</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <form method="POST" name="form" id="ticketform" action="#">
            <table class="formulier">
                <tr>
                    <td>
                        <h2>Rechtgroep toevoegen</h2>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="rechtgroep_naam" placeholder="Rechtgroep naam">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="recht_bitfield" placeholder="Recht bitfield">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" class="knopje" name="submit" value="Aanmaken">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>