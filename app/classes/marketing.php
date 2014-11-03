<?php
require_once 'error.php';
require_once FILE_DB_MARKETING;

/**
 * This is the class that facilitates
 *  the marketing_klant_email functionality.
 *
 * @author Martijn Wink
 * @version 0.1
 */
class Marketing extends Error {

    private $klant_id;
    private $voornaam;
    private $achternaam;
    private $postcode;
    private $voorkeuren;
    private $geboortedatum;
    private $createtime;
  
    /**
     *
     * @param int $id optional or current omschrijving_id
     */
     public function Marketing($klant_id=''){
        if ( !empty($klant_id) ){
            /* Load class vars */
            $db = new DbMarketing($klant_id);
            if ((!$db === FALSE) || ($db === '')){
                $this->klant_id = $klant_id;
                $this->getKlant_id($klant_id);
            
            }

            
        }
    }
 
    /* set functions */

   public function getKlant_id($klant_id){
        if(!empty($klant_id)){
            $this->klant_id = trim($klant_id);
            return TRUE;
        }
        return FALSE;
    }
    public function setVoornaam($voornaam){
        if(!empty($voornaam)){
            $this->voornaam = $voornaam;
            return TRUE;
        }
        return FALSE;
      
    }
    
    public function setAchternaam($achternaam){
        if(!empty($achternaam)){
            $this->achternaam = $achternaam;
            return TRUE;
        }else{
        return FALSE;
        }
    }
    
    public function setPostcode($postcode){
        if(!empty($postcode)){
            $this->postcode= $postcode;
            return TRUE;
        }else{
        return FALSE;
        }
    } 
     
     public function setVoorkeuren($voorkeuren){
        if(!empty($voorkeuren)){
            $this->voorkeuren= $voorkeuren;
            return TRUE;
        }else{
        return FALSE;
        }
    }
    
      public function setGeboortedatum($geboortedatum){
        if(!empty($geboortedatum)){
            $this->geboortedatum= $geboortedatum;
            return TRUE;
        }else{
        return FALSE;
        }
    }
          
        public function saveKlant(){
        $db_marketing = new DbMarketing();

        if (!$db_marketing->save( $this->voornaam, $this->achternaam, $this->postcode, $this->voorkeuren, $this->geboortedatum)){
            $this->setErrorArray($db_marketing->getErrorArray());
            return FALSE;
        } 
        $this->id = $db_marketing->getKlant_id();
        // create notification
        return TRUE;
    } 



 public function wijzigKlant(){
       $db_marketing = new DbMarketing($this->klant_id);
       
       if (!$db_marketing->updateKlant($this->voornaam, $this->achternaam, $this->postcode, $this->voorkeuren, $this->geboortedatum)){
           $this->setErrorArray($db_marketing->getErrorArray());
           return FALSE;
       }
       return TRUE;
   } 
   
  public function selectKlant(){
       $db_marketing = new DbMarketing($this->id);
       
       if (!$db_marketing->getKlant($klant_id)){
           $this->setErrorArray($db_marketing->getErrorArray());
           return FALSE;
       }
       return TRUE;
   }
   public function verwijderKlant(){
       $db_marketing = new DbMarketing($this->klant_id);
       
       if(!$db_marketing->deleteKlant()){
           $this->setErrorArray($db_marketing->getErrorArray());
           return FALSE;
       }
       return TRUE;
   }
} 
  

/* test classe */ 
class TestMarketing {

    public function TestMarketing(){
        echo 'Nieuwe klant wordt aangemaakt';
        $test = new Marketing();
 
        $test->setVoornaam('Gerhard');
        $test->setAchternaam('Hoogendoorn');        
        $test->setPostcode('4562SM');
        $test->setVoorkeuren('2');
        $test->setGeboortedatum('03/12/1850');
        echo "<pre>";
        //var_dump($test);
        echo "</pre>";
        
        $test->saveKlant();

        echo '<br />';
        echo 'Klant updaten';
        $test1 = new Marketing(62);
        
        $test1->setVoornaam('Martijn');
        $test1->setAchternaam('Wink\'s');        
        $test1->setPostcode('4562AM');
        $test1->setVoorkeuren('2');
        $test1->setGeboortedatum('03-12-1853');
        var_dump($test1);
        
        if (!$test1->wijzigKlant()){
            $errs = $test1->getErrorArray();
            foreach($errs as $idx => $error){
                echo "$error<br />\n";
            }
        }          
        
        echo '<br />';
        echo 'Verwijderen klant <br>';
        $test2 = new Marketing(60); 
        
        $test2->verwijderKlant();
		echo "<br>";

		echo "<br>";
        echo "Resultaten ophalen.<br />";
        $test2 = new DbMarketing(50);
        echo "Klant ID: "           . $test2->getKlant_id()             . "<BR>";
        echo "Voornaam  "           . $test2->getVoornaam()             . "<BR>";
        echo "Achternaam: "         . $test2->getAchternaam()           . "<BR>";
        echo "Postcode: "           . $test2->getPostcode()             . "<BR>";
        echo "Voorkeuren: "         . $test2->getVoorkeuren()           . "<BR>";
        echo "Geboortedatum:"       . $test2->getGeboortedatum()        . "<BR>";

        echo "<pre>";
        //var_dump($test2);
        echo "</pre>";
        if($test2->getErrorNr() > 0 ){
        $error=$test2->getErrorArray();
        var_dump($error);
        }
    }

}

?>

