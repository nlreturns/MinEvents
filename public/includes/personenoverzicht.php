<?php
include_once 'classes/persoon.php';
$persoon = new Persoon();
$persoon_array = $persoon->getPersoonList();
$countArray = count($persoon_array);
?>
<h2>
    Persoon overzicht
</h2>
<table class="tabel">
    <thead> 
       <tr>
            <th>Persoon voornaam</th>
            <th>Persoon achternaam</th>
            <th>Persoon email</th>
            <th>Persoon land</th>
            <th>Persoon stad</th>
            <th>Persoon straat</th>
            <th>Persoon tel. nr.</th>
        </tr>
    </thead>
    <tbody>
<?php
    for ($i = 0; $i < $countArray; $i++) {
        echo '<tr>';
        echo '<td>';
        echo $persoon_array[$i]['persoon_voornaam'];
        echo '</td>';
        echo '<td>';
        echo $persoon_array[$i]['persoon_achternaam'];
        echo '</td>';
        echo '<td>';
        echo $persoon_array[$i]['persoon_email'];
        echo '</td>';
        echo '<td>';
        echo $persoon_array[$i]['persoon_land'];
        echo '</td>';
        echo '<td>';
        echo $persoon_array[$i]['persoon_stad'];
        echo '</td>';
        echo '<td>';
        echo $persoon_array[$i]['persoon_straat'];
        echo '</td>';
        echo '<td>';
        echo $persoon_array[$i]['persoon_telnummer'];
        echo '</td>';
        echo '</tr>';
    }
?>
    </tbody>
</table>

