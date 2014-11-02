
<?php
require_once 'error.php';
require_once FILE_DB_ROOSTER;
require_once FILE_CLASS_ROOSTER_TIJDBLOK;
/**
 * Description of rooster
 *
 * @author trinco ingels
 * @version 0.1
 */
class Rooster extends Error{

    private $rooster_id;
    private $roosterstatus_id;
    private $roosterstatus;
    private $tekst;
    private $aanmaakpersoon;
    private $creatietijd;
    private $tijdobj;


    /**
     *
     * @param int $id optional or current rooster_id
     */
    public function Rooster($rooster_id=''){
        if ( !empty($rooster_id) ){
            /* Load class vars */
            $db = new DbRooster($rooster_id);
            if ((!$db === FALSE) || ($db === '')){
                $this->rooster_id = $rooster_id;
                $this->getRooster($rooster_id);

            
            } 
        }
    }

   public function getRooster($rooster_id){
        if(!empty($rooster_id)){
            $this->rooster_id = trim($rooster_id);
            return TRUE;
        }
        return FALSE;
    }
    public function setTekst($tekst){
        if(!empty($tekst)){
            $this->tekst = $tekst;
            return TRUE;
        }
        return FALSE;
      
    }
    
    public function setRoosterstatus($roosterstatus){
        if(!empty($roosterstatus)){
            $this->roosterstatus = $roosterstatus;
            return TRUE;
        }else{
        return FALSE;
        }
    }
    
    public function setAanmaakpersoon($aanmaakpersoon){
        if(!empty($aanmaakpersoon)){
            $this->aanmaakpersoon = $aanmaakpersoon;
            return TRUE;
        }else{
        return FALSE;
        }
    }
    
    public function setStatusId($roosterstatus_id){
        if(!empty($roosterstatus_id)){
            $this->roosterstatus_id = trim($roosterstatus_id);
            return TRUE;
        }else{
        return FALSE;
        }
    }
    
    public function setRoosterId($rooster_id){
        if(!empty($rooster_id)){
            $this->rooster_id = trim($rooster_id);
            return TRUE;
        }else
            return FALSE;
    }

    /**
     * @param string $roosterstatus Status from rooster
     * @param string $tekst Tekst can be included
     * @param string $aanmaakpersoon Peron who made rooster
     */
    
    public function saveRooster(){
        $db_rooster = new DbRooster();

        if (!$db_rooster->save($this->roosterstatus_id, $this->roosterstatus, $this->tekst, $this->aanmaakpersoon)){
            $this->setErrorArray($db_rooster->getErrorArray());
            return FALSE;
        }
        $this->id = $db_rooster->getRoosterId();
        // create notification
        return TRUE;
    }
/**
 * TO DO:
 * function object must be add tijdblok
 * 
 * variable begintijd and eindtijd should be a paramater and set by rooster.php
 * 
 */    
    public function object(){
        /*** create an object ***/
    $this->tijdobj = new tijdblok();
    $this->tijdobj->setRoosterId('1');
    echo $this->tijdobj->getEindtijd();
    $this->tijdobj->setBegintijd('2012-02-01 20:37:24');
    $this->tijdobj->setEindtijd('2013-02-01 20:37:24');

   
    echo '<br>';    
    echo $this->tijdobj->getRoosterId();
    echo '<br>';
    echo $this->tijdobj->getBegintijd();
    echo '<br>';
    echo $this->tijdobj->getEindtijd();
    
    }
    
    /**
     *  Change all entry's from rooster
     * @return bool
     */
   public function wijzigRooster(){
       $db_rooster = new DbRooster($this->rooster_id);
       
       if (!$db_rooster->updateRooster($this->roosterstatus_id, $this->roosterstatus, $this->tekst, $this->aanmaakpersoon)){
           $this->setErrorArray($db_rooster->getErrorArray());
           return FALSE;
       }
       return TRUE;
   }

    /**
     *  Select all entry's from rooster
     * @return bool
     */  
   public function selectRooster(){
       $db_rooster = new DbRooster($this->id);
       
       if (!$db_rooster->getRooster($rooster_id)){
           $this->setErrorArray($db_rooster->getErrorArray());
           return FALSE;
       }
       return TRUE;
   }
   public function verwijderRooster(){
       $db_rooster = new DbRooster($this->rooster_id);
	   
       if(!$db_rooster->deleteRooster()){
           $this->setErrorArray($db_rooster->getErrorArray());
           return FALSE;
       }
       return TRUE;
   }
}

class TestRooster {

    public function TestRooster(){
        echo 'Nieuw rooster invoegen';
        $test = new Rooster();
        
        $test->setStatusId(1);
        $test->setRoosterstatus('nieuw');
        $test->setTekst('teksten');        
        $test->setAanmaakpersoon('mario');
        
        if (!$test->saveRooster()){
            $errs = $test->getErrorArray();
            foreach($errs as $idx => $error){
                echo "$error<br />\n";
            }
        }  
        $test->object();

        echo '<br /><br />';
        
        echo 'Rooster updaten a.d.h.v. ID<br>';
        $test1 = new Rooster(1000);
        
        $test1->setStatusId(2);
        $test1->setRoosterstatus('oud');
        $test1->setTekst('tekstenes');        
        $test1->setAanmaakpersoon('trinco');
        
        if (!$test1->wijzigRooster()){
            $errs = $test1->getErrorArray();
            foreach($errs as $idx => $error){
                echo "$error<br />\n";
            }
        }          
        echo '<br />';        
        
        echo 'Verwijderen van een rooster a.d.h.v. ID<br>';
        $test2 = new Rooster(10);
        
        if (!$test2->verwijderRooster()){
            $errs = $test2->getErrorArray();
            foreach($errs as $idx => $error){
                echo "$error<br />\n";
            }
        }          
        echo '<br />';
        
        echo "Test 2 DbRooster: Haalt waarden uit de database a.d.h.v. ID.<br />";
        $test3 = new DbRooster(1);
        echo "Rooster ID: "        . $test3->getRoosterId()       . "<BR>";
        echo "Roosterstatus ID: ". $test3->getRoosterStatusId() . "<BR>";
        echo "Roosterstatus: "   . $test3->getRoosterStatus()   . "<BR>";
        echo "Tekst: "           . $test3->getTekst()           . "<BR>";
        echo "Creatietijd: "     . $test3->getCreatietijd()     . "<BR>";
        echo "Aanmaakpersoon: "    . $test3->getAanmaakpersoon()  . "<BR>";

        if($test3->getErrorNr() > 0 ){
        $error=$test3->getErrorArray();
        }
        
        
    }

}

?>
