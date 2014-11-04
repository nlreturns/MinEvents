<?php
namespace minevents\app\classes;

/**
 * This is the class that facilitates
 *  the marketing_klant_email functionality.
 *
 * @author Martijn Wink
 * @version 0.1
 */
class MarketingTelefoonlijst extends Error {

    private $klant_id;
    private $nummer;
    private $type;
  
    /**
     *
     * @param int $id optional or current omschrijving_id
     */
    public function telefoonlijst ($klant_id=''){
        if ( !empty($klant_id) ){
            /* Load class vars */
            $db = new DbMarketing_telefoonlijst ($klant_id);
            if ((!$db === FALSE) || ($db === '')){
                $this->klant_id= $klant_id;
                $this->getKlantId($klant_id);
            
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
    public function setNummer($nummer){
        if(!empty($nummer)){
            $this->nummer = $nummer;
            return TRUE;
        }
        return FALSE;
      
    }
    
    public function setType($type){
        if(!empty($type)){
            $this->type = $type;
            return TRUE;
        }else{
        return FALSE;
        }
    }
    
 
          
        public function saveTelefoonlijst(){
        $db_marketing_telefoonlijst = new DbMarketing_telefoonlijst();

        if (!$db_marketing_telefoonlijst->save( $this->nummer, $this->type)){
            $this->setErrorArray($db_marketing_telefoonlijst->getErrorArray());
            return FALSE;
        } 
        $this->id = $db_marketing_telefoonlijst->getKlant_id();
        // create notification
        return TRUE;
    } 



 public function wijzigTelefoonlijst(){
       $db_marketing_telefoonlijst = new DbMarketing_telefoonlijst($this->klant_id);
       
       if (!$db_marketing_telefoonlijst->UpdateTelefoonlijst(@$nummer, @$type)){
           $this->setErrorArray($db_marketing_telefoonlijst->getErrorArray());
           return FALSE;
       }
       return TRUE;
   } 
   
  public function selectTelefoonlijst(){
       $db_marketing_telefoonlijst= new DbMarketing_telefoonlijst($this->id);
       
       if (!$db_marketing_telefoonlijst->getKlant($klant_id)){
           $this->setErrorArray($db_marketing_telefoonlijst->getErrorArray());
           return FALSE;
       }
       return TRUE;
   }
   public function verwijderTelefoonlijst(){
       $db_marketing_telefoonlijst = new DbMarketing_telefoonlijst($this->klant_id);
       
       if(!$db_marketing_telefoonlijst->deleteTelefoonlijst()){
           $this->setErrorArray($db_marketing_telefoonlijst->getErrorArray());
           return FALSE;
       }
       return TRUE;
   }
} 
  

/* test classe */ 
class TestMarketing_telefoonlijst {

    public function TestMarketing_telefoonlijst(){
        echo 'Nieuwe klant wordt aangemaakt';
        $test = new Marketing_telefoonlijst();
 
        $test->setNummer('0623529357');
        $test->setType('2');        
  
        echo "<pre>";
        //var_dump($test);
        echo "</pre>";
        
        $test->saveTelefoonlijst();

        echo '<br />';
        echo 'Klant updaten';
        $test1 = new Marketing_telefoonlijst(12);
        
        $test1->setNummer('0623529357');
        $test1->setType('2');      
        
        if (!$test1->wijzigTelefoonlijst()){
            $errs = $test1->getErrorArray();
            foreach($errs as $idx => $error){
                echo "$error<br />\n";
            }
        }          
        
        echo '<br />';
        echo 'Verwijderen klant <br>';
        $test2 = new Marketing_telefoonlijst(60); 
        
        $test2->verwijderTelefoonlijst();
		echo "<br>";

		echo "<br>";
        echo "Resultaten ophalen.<br />";
        $test2 = new DbMarketing_telefoonlijst(3);
        echo "Nummer: "             . $test2->getNummer()               . "<BR>";
        echo "Type:  "              . $test2->getType()                 . "<BR>";

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