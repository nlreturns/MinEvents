<?php
require_once 'error.php';
require_once FILE_DB_MARKETING_EMAIL;

/**
 * This is the class that facilitates
 *  the marketing_email functionality.
 *
 * @author Martijn Wink
 * @version 0.1
 */
class Marketing_email extends Error {

    private $klant_id;
    private $emailadres;
    private $beschrijving;

    /**
     *
     * @param int $id optional or current klant_id
     */
    public function Email($klant_id=''){
        if ( !empty($klant_id) ){
            /* Load class vars */
            $db = new DbMarketing_email($klant_id);
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
    public function setEmailadres($emailadres){
        if(!empty($emailadres)){
            $this->emailadres = $emailadres;
            return TRUE;
        }
        return FALSE;
      
    }
    
    public function setBeschrijving($beschrijving){
        if(!empty($beschrijving)){
            $this->beschrijving= $beschrijving;
            return TRUE;
        }else{
        return FALSE;
        }
    }
          
        public function saveEmail(){
        $db_marketing_email = new DbMarketing_email();

        if (!$db_marketing_email->save( $this->emailadres, $this->beschrijving)){
            $this->setErrorArray($db_marketing_email->getErrorArray());
            return FALSE;
        } 
        $this->id = $db_marketing_email->getKlant_id();
        // create notification
        return TRUE;
    } 



 public function wijzigEmail(){
       $db_marketing_email = new DbMarketing_email($this->klant_id);
       
       if (!$db_marketing_email->updateEmail($this->emailadres, $this->beschrijving)){
           $this->setErrorArray($db_marketing_email->getErrorArray());
           return FALSE;
       }
       return TRUE;
   } 
   
  public function selectEmail(){
       $db_marketing_email = new DbMarketing_email($this->id);
       
       if (!$db_marketing_email->getEmail($klant_id)){
           $this->setErrorArray($db_marketing_email->getErrorArray());
           return FALSE;
       }
       return TRUE;
   }
   public function verwijderEmail(){
       $db_marketing_email = new DbMarketing_email($this->klant_id);
       
       if(!$db_marketing_email->deleteEmail()){
           $this->setErrorArray($db_marketing_email->getErrorArray());
           return FALSE;
       }
       return TRUE;
   }
} 

/* test classe */ 
class TestMarketing_email {

    public function TestMarketing_email(){
        echo 'Nieuwe Email';
        $test = new Marketing_email();
 
        $test->setEmailadres('henkie@hotmail.com');
        $test->setBeschrijving('dit is de beschrijving');        

        echo "<pre>";
        //var_dump($test);
        echo "</pre>";
        
        $test->saveEmail();

        echo '<br />';
        echo 'Email Updaten';
        $test1 = new Marketing_email(12);
        
        $test1->setEmailadres('sjaak@hotmail.com');
        $test1->setBeschrijving('dit is geen beschrijving');   
        if (!$test1->wijzigEmail()){
            $errs = $test1->getErrorArray();
            foreach($errs as $idx => $error){
                echo "$error<br />\n";
            }
        }       
        
        echo '<br />';
        echo 'Verwijderen email <br>';
        $test2 = new Marketing_email(2); 
        
        $test2->verwijderEmail();
		echo "<br>";

		echo "<br>";
        echo "Resultaten ophalen.<br />";
        $test2 = new DbMarketing_email(3);
        echo "Klantid : "             . $test2->getKlant_id()             . "<BR>";
        echo "Emailadres: "           . $test2->getEmailadres()             . "<BR>";
        echo "Beschrijving: "         . $test2->getBeschrijving()           . "<BR>";

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