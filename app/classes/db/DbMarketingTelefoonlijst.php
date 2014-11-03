<?php
namespace minevents\app\classes\db;
/**
 * Description of db_marketing_telefoonlijst
 * 
 *
 * @author MARTIJN WINK
 * @version 0.1
 */
class DbMarketingTelefoonlijst extends Database {

    private $klant_id;
    private $nummer;
    private $type;

    public function DbMarketing_telefoonlijst(){
        parent::__construct();

        /* Check whether the database already is created */
        if( !$this->dbTableExists(TBL_MARKETING_TELEFOONLIJST)){
            $this->createTable();
        }
    }

    public function save($nummer, $type){

        
        if (    $this->checkNummer($nummer)                     &&
                $this->checkType($type)                         ){                                     

            $query= "INSERT INTO `".TBL_MARKETING_TELEFOONLIJST.
                    "`(`". FIELD_MARKETING_NUMMER.   "`,`".
                    FIELD_MARKETING_TYPE     . "`)".
                    
                    " VALUES ('".$nummer."','".   
                    $this->dbInString($type)."')";
                          
            $this->dbquery($query);
            if($this->checkDbErrors($query)){
                return FALSE;
            }

            /* Update class attributes */
            $this->klant_id = mysql_insert_id($this->connection);
            $this->nummer = $nummer;
            $this->type = $type;

        } else {
            return FALSE;
        }
        return TRUE;
    }

   public function getKlant_id(){
         if(!empty($this->klant_id)){
            return $this->klant_id;
        }return FALSE;
        $this->setError(TXT_ERROR. TXT_NO_VALID_KLANT_ID);
    }

    
    public function getNummer() {
        return $this->nummer;
    }
    
    public function getType() {
        return $this->type;
    }
       
    /**
     * Collect class data and return.<br />
     * When a different or new id is provided the class vars
     * are loaded from the database.
     */
    public function updateTelefoonlijst($nummer, $type){

        if (    $this->checkNummer($this->nummer, FIELD_MARKETING_NUMMER) &&
                $this->checkType($this->type, FIELD_MARKETING_TYPE)){        
                        
            $query = "UPDATE `". DB_NAME ."`.`".TBL_MARKETING_TELEFOONLIJST .
                    "` SET `".FIELD_MARKETING_NUMMER."` = '".$nummer."',`".
                    FIELD_MARKETING_TYPE."` = '".$this->dbInString($type)."',`".
                    "'WHERE `". TBL_MARKETING_TELEFOONLIJST ."`.`".FIELD_MARKETING_KLANT_ID."` ='".$this->klant_id."'";
            $result = $this->dbquery($query);
            var_dump($query);
            return ($this->checkDbErrors($query));
            
        }
        return FALSE;
    }
    
    public function deleteTelefoonlijst(){

        if (    $this->checkKlant_id ($this->klant_id, FIELD_MARKETING_KLANT_ID) ){         
                       
            $query = "DELETE FROM `". DB_NAME ."`.`".TBL_MARKETING_TELEFOONLIJST .
                    "`WHERE `".FIELD_MARKETING_KLANT_ID."` ='".$this->klant_id."'";
            $result = mysql_query($query);
                 echo "Entry is verwijderd!";
		 return ($this->checkDbErrors($query));
        }
           // $this->setError(TXT_ERROR. TXT_NO_VALID_KLANT_ID);

    }

    
     /* Check the provided id */
     
    private function checkKlant_Id($klant_id){
        if ( !$this->checkId($klant_id, FIELD_MARKETING_KLANT_ID)){
            return FALSE;
        }
        return TRUE;
    }


     /* check on string lenght and empty fields */

        private  function checkNummer($nummer){
        return TRUE;
        if ( empty($nummer)){
            $this->setError( TXT_ERROR_EMPTY . FIELD_MARKETING_NUMMER);
            trigger_error(__FILE__. ' '.__LINE__ . ' Found errors '. __FUNCTION__ . '<br/>');
            return FALSE;
        } else {
            
        }
        return TRUE;
    }
    
    private  function checkType($type){
        return TRUE;
        if ( empty($type)){
            $this->setError( TXT_ERROR_EMPTY . FIELD_MARKETING_TYPE);
            trigger_error(__FILE__. ' '.__LINE__ . ' Found errors '. __FUNCTION__ . '<br/>');
            return FALSE;
        } else {
            
        }
        return TRUE;
    }
 

    /**
     *  Class telefoonlijst reset:<br />
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
        $this->nummer = '';
        $this->type = '';
          
    }

    /**
     *
     * Load omschrijvingid with $id from database.<br />
     *  When a different id is provided, the class is reset
     *  and loaded with the new id.
     */
    private function getDbMarketing_telefoonlijst($id =''){

        if( empty($klant_id) && empty($this->klant_id)){
            /* Both empty is error */
               $this->setError(TXT_ERROR. TXT_NO_VALID_KLANT_ID);
            return FALSE;

        } else if( !empty($klant_id) && empty($this->klant_id)){
            /* New id load */
            $this->getDbMarketing_telefoonlijst($klant_id);

        } if (!empty($klant_id) && !empty($this->klant_id) && ($klant_id != $this->klant_id)){
            /* Different Id reload */
            $this->getDbMarketing_telefoonlijst($klant_id);
        } else {
            /* Valid class id */
        }
          if ( !$this->checkKlant_id($this->klant_id) ){
            /* Finaly still no valid msg id */
            return FALSE;
        }

        if (!$this->checkId($id, FIELD_MARKETING_KLANT_ID)){
            return FALSE;
        }
        $query = "SELECT `". FIELD_MARKETING_KLANT_ID ."`,`".
                             FIELD_MARKETING_NUMMER."`,`".
                             FIELD_MARKETING_TYPE."`".

                " FROM `".TBL_MARKETING_TELEFOONLIJST."`".
                " WHERE `". FIELD_MARKETING_KLANT_ID ."` = '". $id ."'";
        $this->dbquery($query);
        if ( $this->checkDbErrors($query) ){
            return FALSE;
        }
        $msg_array = $this->dbFetchArray();

        if ($msg_array !== FALSE){

            /* Save class data */
           
            $this->klant_id = $msg_array[FIELD_MARKETING_KLANT_ID];
            $this->nummer = $msg_array[FIELD_MARKETING_NUMMER];
            $this->type = $msg_array[FIELD_MARKETING_TYPE];

            return TRUE;
        }
        return FALSE;

    }


     private function createTable(){
        
        /* Table MARKETING_KLANT_telefoonlijst */
        $q = "CREATE TABLE IF NOT EXISTS `".DB_NAME."`.`". TBL_MARKETING_TELEFOONLIJST ."` (".
            "`".FIELD_MARKETING_KLANT_ID."` bigint(10) NOT NULL AUTO_INCREMENT,".
            "`".FIELD_MARKETING_NUMMER."` bigint(15) NOT NULL,".
            "`".FIELD_MARKETING_TYPE."` bigint(10) NOT NULL,".
            "PRIMARY KEY  (`".FIELD_MARKETING_KLANT_ID."`),".
            "KEY `idx_".FIELD_MARKETING_TYPE."` (`".FIELD_MARKETING_TYPE."`)".
            ") ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs";

        if ( !$this->dbquery($q)) {
            $this->checkDbErrors($q);
            trigger_error(__FILE__. ' '.__LINE__ . ' Found errors '. __FUNC__ . '<br/>');
            return FALSE;
        }
    }
/*}

class TestDbMarketing_telefoonlijst{

    public function TestDbMarketing_telefoonlijst(){

      echo "******************************************************************<br />";
        $test = new DbMarketing_telefoonlijst();

        $test->save(1, 2, 3, 4, 5, 6);
        
        /* echo "<pre>";
        var_dump($test->getErrorArray());
        echo "</pre>"; 
        
        /*
        echo "<pre>";
        var_dump($test);
        echo "</pre>";
        //*/

    /*    echo "MARKETING KLANT telefoonlijst<br />";
        $test2 = new DbMarketing_telefoonlijst(2);
        echo "Omschrijving ID: "                . $test2->getOmschrijving_Id()       . "<BR>";
        echo "Telefoonnummer thuis: "           . $test2->getTelthuis()              . "<BR>";
        echo "Telefoonnummer zakelijk : "       . $test2->getTelzakelijk()           . "<BR>";  
        echo "Telefoonnummer overig : "          . $test2->getTeloverig()              . "<BR>"; 
        echo "Gsmnummer prive : "               . $test2->getGsmprive()              . "<BR>"; 
        echo "Gsmnummer zakelijk : "            . $test2->getGsmzakelijk()           . "<BR>"; 
        echo "Gsmnummer overig : "              . $test2->getGsmoverig()             . "<BR>";
        
         echo "UPDATE<br />";
        $test3 = new DbMarketing_telefoonlijst(3);
        $test3->updatetelefoonlijst (6, 5, 4, 3, 2, 1);
        
         echo "DELETE<br />";
        $test4 = new DbMarketing_telefoonlijst(13);
        $test4->deletetelefoonlijst();
        var_dump($test4->getErrorArray()); 
     
    } */
}
?>
