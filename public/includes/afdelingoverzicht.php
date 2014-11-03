<?php

include_once 'classes/Afdeling.php';
$afdeling = new Afdeling();
$afdeling_array = $afdeling->getList();

$countArray = count($afdeling_array);
?>
<h2>
    Afdeling overzicht
</h2>
<table class="tabel">
    <thead> 
       <tr>
            <th>Afdeling Naam</th>
            <th>Afdeling Beschrijving</th>
        </tr>
    </thead>
    <tbody>
<?php
    for ($i = 0; $i < $countArray; $i++) {
        echo '<tr>';
        
        echo '<td>';
        echo $afdeling_array[$i]['afdeling_naam'];
        echo '</td>';
        
        echo '<td>';
        echo $afdeling_array[$i]['afdeling_beschrijving'];
        echo '</td>';
        
        echo '</tr>';
    }
?>
    </tbody>
</table>

