<?php
use minevents\app\classes\Persoon as Persoon;



if (isset($_POST['Verzenden'])) {
    
    /**
     * Update persoon groeps ID
     */
    $persoon = new Persoon();      
    $persoon->updateGroepsnr($_POST['persoon_id'], $_POST['groep_id']);           
}

// Haal informatie voor deze pagina op
$persoon = new Persoon();
$persoon_array = $persoon->getPersoonList();
$persoon_groep_array = $persoon->getGroepList();
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
            <th>Persoon groep</th>
            <th>Persoon stad</th>
            <th>Persoon straat</th>
        </tr>
    </thead>
    <tbody>
<?php
    for ($i = 0; $i < $countArray; $i++) {
        echo '<form action="#" method="post">';
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
        echo '<select name="groep_id" >';
        foreach ($persoon_groep_array as $groep){
            if ($groep['persoon_groep_id'] == $persoon_array[$i]['persoon_groep']){
                echo "<option value='".  $groep['persoon_groep_id']."' selected>". $groep['persoon_groep_naam'] ."</option>";
            }
            else {
                echo "<option value='".  $groep['persoon_groep_id']."'>". $groep['persoon_groep_naam'] ."</option>";
            }
            
        }
        echo '<input type="hidden" name="persoon_id" value="' . $persoon_array[$i]['persoon_id'] . '">';
        echo '<input type="hidden" name="id" value="' . $persoon_groep_array[$i]['persoon_groep_id'] . '">';
        echo '<input type="submit" class="knopje" name="Verzenden" value="Wijzig" />';
        echo '</select>';
        echo '</td>';
        echo '<td>';
        echo $persoon_array[$i]['persoon_stad'];
        echo '</td>';
        echo '<td>';
        echo $persoon_array[$i]['persoon_straat'];
        echo '</td>';
        echo '</tr>';
        echo  '</form>';
    }
?>
    </tbody>
</table>
