<?php
include_once 'classes/gebruiker.php';
$gebruiker = new Gebruiker(new DbGebruiker());
$gebruiker_array = $gebruiker->getGebruikerList();

$countArray = count($gebruiker_array);
?>
<h2>
    Gebruiker overzicht
</h2>
<table class="tabel">
    <thead> 
       <tr>
            <th>Gebruikersnaam</th>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
<?php
    for ($i = 0; $i < $countArray; $i++) {
        echo '<tr>';
        echo '<td>';
        echo $gebruiker_array[$i]['gebruiker_naam'];
        echo '</td>';
        echo '<td>';
        echo '<a href="?page=gebruikers&subpage=gebruikerview&id='
            . $gebruiker_array[$i]['gebruiker_id'] . '">
            <img src="img/view.png""/></a>';
        echo '</td>';
        echo '</tr>';
    }
?>
    </tbody>
</table>