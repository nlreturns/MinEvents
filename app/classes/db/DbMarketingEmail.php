<?php
namespace minevents\app\classes\db;
/**
 * Description of db_marketing_email
 * 
 *
 * @author Martijn Wink
 * @version 0.1
 */
class DbMarketingEmail extends Database {

    private $klant_id;
    private $emailadres;
    private $beschrijving;

    public function DbMarketing_email(){
        parent::__construct();

        /* Check whether the database already is created */
        if( !$this->dbTableExists(TBL_MARKETING_EMAIL)){
            $this->createTable();
        }
    }
    
    /* save function */  
    public function save( $emailadres, $beschrijving){

             if (   $this->checkEmailadres($emailadres)               &&
                    $this->checkBeschrijving($beschrijving)           ){   
                      
            $query= "INSERT INTO `".TBL_MARKETING_EMAIL.
                    "`(`".FIELD_MARKETING_EMAILADRES .     "`,`".
                    FIELD_MARKETING_BESCHRIJVING .      "`)".                                  
                    " VALUES ('".$this->dbInString($emailadres)."','".
                    $this->dbInString($beschrijving)."')";
                  
            $this->dbquery($query);
            
            if($this->checkDbErrors($query)){
                return FALSE;
                
               
            }

            /* Update class attributes */
            $this->klant_id = mysql_insert_id($this->connection);
            $this->emailadres = $emailadres;
            $this->beschrijving = $beschrijving;         

        } else {
            return FALSE;
        }
        return TRUE;
    }
    
    /* Select function */
    /* Check of 'klantid' is empty */
   public function getKlant_Id(){
        if (!empty($this->klant_id)){
            return $this->klant_id;
        }return FALSE;
        $this->setError(TXT_ERROR. TXT_NO_VALID_KLANT_ID);
    }
    
     public function getEmailadres() {
        return $this->emailadres;
    }
    
    public function getBeschrijving() {
        return $this->beschrijving;
    }
    
     /**
     * Collect class data and return.<br />
     * When a different or new id is provided the class vars
     * are loaded from the database.
     *
     * The firsth status is always new,
     * but the Id does change.
     */
    
    /* Update the description of a email entry */
    public function updateEmail($emailadres, $beschrijving){

        if (    $this->checkEmailadres($this->emailadres, FIELD_MARKETING_EMAILADRES) &&
                $this->checkBeschrijving($this->beschrijving, FIELD_MARKETING_BESCHRIJVING)){             

            $query = "UPDATE `". DB_NAME ."`.`".TBL_MARKETING_EMAIL .
                    "` SET `".FIELD_MARKETING_EMAILADRES."` = '".$this->dbInString($emailadres)."',`".
                    FIELD_MARKETING_BESCHRIJVING."` = '".$this->dbInString($beschrijving)."',`".
                     "'WHERE `". TBL_MARKETING_EMAIL ."`.`".FIELD_MARKETING_KLANT_ID."` ='".$this->klant_id."'";
            $result = $this->dbquery($query);
           
            return ($this->checkDbErrors($query));
            
        }
        return FALSE;
    }
   
    /* Delete row in db_marketing_email table */
    public function deleteEmail(){

        if (    $this->checkKlant_Id ($this->klant_id, FIELD_MARKETING_KLANT_ID) ){         
                       
            $query = "DELETE FROM `". DB_NAME ."`.`".TBL_MARKETING_EMAIL .
                    "`WHERE `".FIELD_MARKETING_KLANT_ID."` ='".$this->klant_id."'";
            $result = $this->dbquery($query);
            var_dump($query);
            return ($this->checkDbErrors($query));
            
        }
        return FALSE;
    }

     /*  Check the provided id´s  */
  
    private function checkKlant_Id($klant_id){
        if ( !$this->checkId($klant_id, FIELD_MARKETING_KLANT_ID)){
            return FALSE;
        }
        return TRUE;
    }
     
        /* check on string lenght and empty fields */
        private function checkEmailadres($emailadres){
        if (    empty($emailadres)   ){
           $this->setError( TXT_ERROR .  FIELD_MARKETING_EMAILADRES);

        } else if ( !is_string($emailadres) ) {
           $this->setError( TXT_ERROR_WRONG_VAR_TYPE. FIELD_MARKETING_EMAILADRES );
        } else if ( strlen($emailadres) > LEN_MARKETING_EMAILADRES ){
            $this->setError( TXT_ERROR_VAR_SIZE . ' '. FIELD_MARKETING_EMAILADRES);
            trigger_error(__FILE__. ' '.__LINE__ . ' Found errors '. __FUNCTION__ . '<br/>');
            return FALSE;
        }
        return TRUE;
    }
    
            private function checkBeschrijving($beschrijving){
        if (    empty($beschrijving)   ){
           $this->setError( TXT_ERROR .  FIELD_MARKETING_BESCHRIJVING);

        } else if ( !is_string($beschrijving) ) {
           $this->setError( TXT_ERROR_WRONG_VAR_TYPE. FIELD_MARKETING_BESCHRIJVING );
        } else if ( strlen($beschrijving) > LEN_MARKETING_BESCHRIJVING ){
            $this->setError( TXT_ERROR_VAR_SIZE . ' '. FIELD_MARKETING_BESCHRIJVING);
            trigger_error(__FILE__. ' '.__LINE__ . ' Found errors '. __FUNCTION__ . '<br/>');
            return FALSE;
        }
        return TRUE;
    }

    /**
     *  Class Messageboard reset:<br />
     *      Reset Error mechanism<br />
     *      Reset Db query results (Not the curren link)<br />
     *      Reset Class attributes<br />
     */
    private function reset(){
        /* Reset Error mechanism */
        $this->resetError();

        /* Reset Database */
        $this->dbReset();

        /* Reset Class attr */
        $this->id = '';
        $this->status_id = 0;
        $this->klant_id = 0;
        $this->voornaam = '';
        $this->achternaam = '';
        $this->postcode = '';
        $this->voorkeuren = '';
        $this->geboortedatum = '';
        $this->createtime = '';          
                                       
    }

    /**
     *
     * Load email with $id from database.<br />
     *  When a different id is provided, the class is reset
     *  and loaded with the new id.
     *
     * @param int $id email id.
     * @return bool TRUE if class data is filled or
     *              FALSE if error found (Check error array)
     */
    private function getDbMarketing_email($klant_id =''){

          if( empty($klant_id) && empty($this->klant_id)){
            /* Both empty is error */
               $this->setError(TXT_ERROR. TXT_NO_VALID_KLANT_ID);
            return FALSE;

        } else if( !empty($klant_id) && empty($this->klant_id)){
            /* New id load */
            $this->getDbMarketing_email($klant_id);

        } if (!empty($klant_id) && !empty($this->klant_id) && ($rooster_id != $this->rooster_id)){
            /* Different Id reload */
            $this->getDbMarketing_email($klant_id);
        } else {
            /* Valid class id */
        }

        if (!$this->checkId($id, FIELD_MARKETING_KLANT_ID)){
            return FALSE;
        }
        $query = "SELECT `". FIELD_MARKETING_KLANT_ID ."`,`".
                            FIELD_MARKETING_EMAILADRES."`,`".
                            FIELD_MARKETING_BESCHRIJVING."`".

                " FROM `".TBL_MARKETING_EMAIL."`".
                " WHERE `". FIELD_MARKETING_KLANT_ID ."` = '". $id ."'";
        $this->dbquery($query);
        if ( $this->checkDbErrors($query) ){
            return FALSE;
        }
        $msg_array = $this->dbFetchArray($query);

        if ($msg_array !== FALSE){

            /* Save class data */
           
            $this->klant_id = $msg_array[FIELD_MARKETING_KLANT_ID];
            $this->emailadres = $msg_array[FIELD_MARKETING_EMAILADRES];
            $this->beschrijving = $msg_array[FIELD_MARKETING_BESCHRIJVING];

            return TRUE;
        }
        return FALSE;

    }


    private function createTable(){
        
        /* Table MARKETING_EMAIL */
        $q = "CREATE TABLE IF NOT EXISTS `".DB_NAME."`.`". TBL_MARKETING_EMAIL ."` (".
            "`".FIELD_MARKETING_KLANT_ID."` bigint(10) NOT NULL AUTO_INCREMENT,".
            "`".FIELD_MARKETING_EMAILADRES."` varchar(".LEN_MARKETING_EMAILADRES.") collate latin1_general_cs NOT NULL,".
            "`".FIELD_MARKETING_BESCHRIJVING."` varchar(".LEN_MARKETING_BESCHRIJVING.") collate latin1_general_cs NOT NULL,".
            "PRIMARY KEY  (`".FIELD_MARKETING_KLANT_ID."`),".
            "KEY `idx_".FIELD_MARKETING_EMAILADRES."` (`".FIELD_MARKETING_EMAILADRES."`)".
            ") ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs";
                
        if ( !$this->dbquery($q)) {
            $this->checkDbErrors($q);
            trigger_error(__FILE__. ' '.__LINE__ . ' Found errors '. __FUNC__ . '<br/>');
            return FALSE; 
            
        }
    }
/*}

 /* class TestDbMarketing_email{

    public function TestDbMarketing_email(){

      /* echo "******************************************************************<br />";
        $test = new DbMarketing_email();

        $test->save('Henk@hotmail.com  ', 'dit is de beschrijving');
        
        /*echo "<pre>";
        var_dump($test->getErrorArray());
        echo "</pre>";       
        
        /*
        echo "<pre>";
        var_dump($test);
        echo "</pre>";
        //*/

     /*   echo "MARKETING KLANT EMAIL<br />";
        $test2 = new DbMarketing_email(2);
        echo "Klant ID: "                       . $test2->getKlant_Id()              . "<BR>";
        echo "Emailadres: "                     . $test2->getEmailadres()              . "<BR>";
        echo "Beschrijving : "                  . $test2->getBeschrijving()           . "<BR>";
        
        echo "UPDATE<br />";
        $test3 = new DbMarketing_email(3);
        $test3->updateEmail(jemoeder, beschrijving);
        
        echo "DELETE<br />";
        $test4 = new DbMarketing_email(13);
        $test4->deleteEmail();
        var_dump($test4->getErrorArray());  
     
   }*/
}
?>
