<?php

use minevents\app\classes\Object as Object;
$object = new Object();
$object_array = $object->getList();

$countArray = count($object_array);
?>
<h2>
    Object overzicht
</h2>
<table class="tabel">
    <thead> 
       <tr>
            <th>Object Naam</th>
            <th>Afdeling</th>
        </tr>
    </thead>
    <tbody>
<?php
    for ($i = 0; $i < $countArray; $i++) {
        echo '<tr>';
        echo '<td>';
        if(isset($object_array[$i]['object_naam'])){
            echo $object_array[$i]['object_naam'];
        }else{
            echo 'Geen gegevens gevonden.';
        }
        
        echo '</td>';
        
        echo '<td>';
        $afdeling = $object->getAfdeling($object_array[$i]['afdeling_id']);
       // $object->getAfdeling($object_array[$i]['afdeling_id']);
        if(isset($afdeling[0]['afdeling_naam'])){
            echo $afdeling[0]['afdeling_naam'];
        }
        
        
        echo '</tr>';
    }
?>
    </tbody>
</table>

