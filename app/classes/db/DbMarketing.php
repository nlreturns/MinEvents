<?php
namespace minevents\app\classes\db;

/**
 * Description of db_marketing
 * 
 * This is the main file of the marketing system. 
 * The file checks if all databases are created. 
 * If this is not the case, these databases will be created
 * when this file is executed. 
 * This is much faster and easier than creating the databases manually.
 * 
 * @author Martijn Wink
 * @version 0.5
 */


/* private functions */
class DbMarketing extends Database {

/*the private functions are defined for DbMarketing.php and Marketing.php */
    private $klant_id;
    private $voornaam;
    private $achternaam;
    private $postcode;
    private $voorkeuren;
    private $geboortedatum;
    private $createtime;

    
/* db_marketing checks if all databases exist 
 * if they don’t exist the databases are created 
 */    
 public function DbMarketing ($klant_id=''){
        parent::__construct();
        /* Check if there is a 'klant_id'    */ 
        if (empty($klant_id)){
            /* Check whether the database TBL_MARKETING already is created */
            if( !$this->dbTableExists(TBL_MARKETING)){
                $this->createTable();
            }
            if( !$this->dbTableExists(TBL_MARKETING_EMAIL)){
                /* Create TBL_MARKETING_EMAIL by calling constructor */
                $msg_type = new DbMarketingEmail();
                unset( $msg_type );                         
            }
         /*   if( !$this->dbTableExists(TBL_MARKETING_TELEFOONTYPE)){
                /* Create by calling constructor */
          /*      $msg_type = new DbMarketing_telefoontype();
                unset( $msg_type );                
            } */
            if( !$this->dbTableExists(TBL_MARKETING_TELEFOONLIJST)){
                /* Create TBL_MARKETING_TELEFOONLIJST by calling constructor */
                $msg_type = new DbMarketing_telefoonlijst();
                unset( $msg_type );                
            }
        /* Check if 'klant_id is already created 
         * if not -> return false
         */    
        } else if ( $this->getDbMarketing($klant_id) === FALSE ){
                /** Update class with db info **/
                return FALSE;
        }
    }   
    
    /* Save function 
     * This feature ensures that all values ​​are saved in the database.
     * It also raises a number of checks that are defined later in this file
     */
    public function save( $voornaam, $achternaam,
                            $postcode, $voorkeuren, $geboortedatum){
        
             if (   $this->checkVoornaam($voornaam)               &&
                    $this->checkAchternaam($achternaam)           &&
                    $this->checkPostcode($postcode)               &&
                    $this->checkVoorkeuren($voorkeuren)           &&
                    $this->checkGeboortedatum($geboortedatum)     ){
     /* 
     * Define the tables 
     */                         
            $query= "INSERT INTO `".TBL_MARKETING.
                    "`(`".FIELD_MARKETING_VOORNAAM.     "`,`".
                    FIELD_MARKETING_ACHTERNAAM.      "`,`".
                    FIELD_MARKETING_POSTCODE.      "`,`".
                    FIELD_MARKETING_VOORKEUREN.      "`,`".
                    FIELD_MARKETING_GEBOORTEDATUM.         "`)".                          
                    " VALUES ('".$this->dbInString($voornaam)."','".
                    $this->dbInString($achternaam)."','".
                    $postcode."','".
                    $this->dbInString($voorkeuren)."','".
                    $geboortedatum."')";
                  
            $this->dbquery($query);
            
            if($this->checkDbErrors($query)){
                return FALSE;
                
               
            }

            /* Update class attributes */
            $this->klant_id = mysql_insert_id($this->connection);
            $this->voornaam = $voornaam;
            $this->achternaam = $achternaam;
            $this->postcode = $postcode;
            $this->voorkeuren = $voorkeuren;
            $this->geboortedatum = $geboortedatum;
            $this->createtime = $this->getCreateTime();

        } else {
            return FALSE;
        }
        return TRUE;
    }
    /* Select function 
     * 
     * Check if 'klantid' is empty
     *  if empty return false
     * 
     * Collect all the information we need 
     * The application will get this information from the database
     */
    public function getKlant_Id($klant_id=''){
        if (!empty($this->klant_id)&& empty($this->klant_id)){
            /* Both empty is error */
               $this->setError(TXT_ERROR. TXT_NO_VALID_KLANT_ID);
            return $this->klant_id;
        }
        return FALSE;
        
    }
    /* get value 'voornaam' */
     public function getVoornaam() {
        return $this->voornaam;
    }
    /* get value 'achternaam' */
    public function getAchternaam() {
        return $this->achternaam;
    }
   /* get value 'postcode' */
    public function getPostcode() {
        return $this->postcode;
    }
    /* get value 'voorkeuren' */
    public function getVoorkeuren() {
        return $this->voorkeuren;
    }
    /* get value 'geboortedatum' */
    public function getGeboortedatum() {
        return $this->geboortedatum;
    }
     
    /* Update the description of a klant entry 
     * 
     * This function will change values  in the database 
     * if some of information isn't correct.
     * 
     * It uses de values that are defined 
     */
     
     public function updateKlant($voornaam, $achternaam, $postcode, $voorkeuren, $geboortedatum){

        if (    $this->checkVoornaam($this->voornaam, FIELD_MARKETING_VOORNAAM) &&
                $this->checkAchternaam($this->achternaam, FIELD_MARKETING_ACHTERNAAM)&&  
                $this->checkPostcode($this->postcode, FIELD_MARKETING_POSTCODE) &&
                $this->checkVoorkeuren($this->voorkeuren, FIELD_MARKETING_VOORKEUREN) &&
                $this->checkGeboortedatum($this->geboortedatum, FIELD_MARKETING_GEBOORTEDATUM) ){
                        
            $query = "UPDATE `". DB_NAME ."`.`".TBL_MARKETING .
                    "` SET `".FIELD_MARKETING_VOORNAAM."` = '".$this->dbInString($voornaam)."',`".
                    FIELD_MARKETING_ACHTERNAAM."` = '".$this->dbInString($achternaam)."',`".
                    FIELD_MARKETING_POSTCODE."` = '".$this->dbInString($postcode)."',`".
                    FIELD_MARKETING_VOORKEUREN."` = '".$this->dbInString($voorkeuren)."',`".
                    FIELD_MARKETING_GEBOORTEDATUM."` = '".$this->dbInString($geboortedatum)."',`".
                    "'WHERE `". TBL_MARKETING ."`.`".FIELD_MARKETING_KLANT_ID."` ='".$this->klant_id."'";
            $result = $this->dbquery($query);
            var_dump($query);
            return ($this->checkDbErrors($query));
            
        }
        return FALSE;
    }
    /* Delete Function
     * 
     * This function can delete customers if they are no longer needed
     * it deletes customers using the 'klant_id' to indentify what customer must be deleted
     */
    public function deleteKlant(){

        if (    $this->checkKlant_Id ($this->klant_id, FIELD_MARKETING_KLANT_ID) ){         
                       
            $query = "DELETE FROM `". DB_NAME ."`.`".TBL_MARKETING .
                    "`WHERE `".FIELD_MARKETING_KLANT_ID."` ='".$this->klant_id."'";
            $result = mysql_query($query);
                 echo "Entry is verwijderd!";
		 return ($this->checkDbErrors($query));
        }
            //$this->setError(TXT_ERROR. TXT_NO_VALID_KLANT_ID);

    }
    
    /* This function saves te time of creating a customer
     * it can be usefull for different reasons
     * one of these reasons is that you can find out how many customers registered on an exact date
     */
    private function getCreateTime(){

        $query = "SELECT `". FIELD_MARKETING_CREATE_TIME ."` FROM `". TBL_MARKETING .
            "` WHERE `". FIELD_MARKETING_KLANT_ID ."`='". $this->klant_id."'";
        $result = $this->dbquery($query);

        if ( !$this->checkDbErrors($query)){

            $row_array = $this->dbFetchArray();
            return $row_array[FIELD_MARKETING_CREATE_TIME];
        }
        return '';
    }  
   
     /*  Check of the 'klant_id' is usefull  */
    private function checkKlant_Id($klant_id){
        if ( !$this->checkId($klant_id, FIELD_MARKETING_KLANT_ID)){
            return FALSE;
        }
        return TRUE;
    }
    
    /* check on string lenght and empty fields 
     * if the conditions are not true
     * ->return false
     */
    
       /*check if field 'voornaam'is not empty */ 
            private function checkVoornaam($voornaam){
        if (    empty($voornaam)   ){
           $this->setError( TXT_ERROR .  FIELD_MARKETING_VOORNAAM);
        
       /*check if field 'voornaam' has the right type variable */    
        } else if ( !is_string($voornaam) ) {
           $this->setError( TXT_ERROR_WRONG_VAR_TYPE. FIELD_MARKETING_VOORNAAM );
     
       /*check the length of 'voornaam'  */     
        } else if ( strlen($voornaam) > LEN_MARKETING_VOORNAAM ){
            $this->setError( TXT_ERROR_VAR_SIZE . ' '. FIELD_MARKETING_VOORNAAM);           
            return FALSE;
        }
        return TRUE;
    }
    
       /*check if field 'achternaam'is not empty */ 
            private function checkAchternaam($achternaam){
        if (    empty($achternaam)   ){
           $this->setError( TXT_ERROR .  FIELD_MARKETING_ACHTERNAAM);
           
       /*check if field 'achternaam' has the right type variable*/  
        } else if ( !is_string($achternaam) ) {
           $this->setError( TXT_ERROR_WRONG_VAR_TYPE. FIELD_MARKETING_ACHTERNAAM );
          
      /*check the length of 'achternaam'  */     
        } else if ( strlen($achternaam) > LEN_MARKETING_ACHTERNAAM ){
            $this->setError( TXT_ERROR_VAR_SIZE . ' '. FIELD_MARKETING_ACHTERNAAM);
            return FALSE;
        }
        return TRUE;
    }
    
      /*check if field 'postcode'is not empty */ 
           private function checkPostcode($postcode){
        if (    empty($postcode)   ){
           $this->setError( TXT_ERROR .  FIELD_MARKETING_POSTCODE);

      /*check the length of 'postcode' */    
        } else if ( strlen($postcode) > LEN_MARKETING_POSTCODE ){
            $this->setError( TXT_ERROR_VAR_SIZE . ' '. FIELD_MARKETING_POSTCODE);
            return FALSE;
        }
        return TRUE;
    }

    /*check if field 'voorkeuren'is not empty */ 
    private  function checkVoorkeuren($voorkeuren){
        return TRUE;
        if ( empty($voorkeuren)){
            $this->setError( TXT_ERROR_EMPTY . FIELD_MARKETING_VOORKEUREN);
            return FALSE;
        } else {
             
        }
        return TRUE;
    }
    
    /*check if field 'geboortedatum'is not empty */
    private  function checkGeboortedatum($geboortedatum){
        return TRUE;
        if ( empty($geboortedatum)){
            $this->setError( TXT_ERROR_EMPTY . FIELD_MARKETING_GEBOORTEDATUM);
            return FALSE;
        } else {
            // look u
        }
        return TRUE;
    }
    
  
    /**
     *  Class marketing reset:<br />
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
     * Load with $id from database.<br />
     *  When a different id is provided, the class is reset
     *  and loaded with the new id.
     *
     * @param int $id klant id.
     * @return bool TRUE if class data is filled or
     *              FALSE if error found (Check error array)
     */
    private function getDbMarketing ($klant_id =''){

       if( empty($klant_id) && empty($this->klant_id)){
            /* Both empty is error */
               $this->setError(TXT_ERROR. TXT_NO_VALID_KLANT_ID);
            return FALSE;

        } else if (!empty($klant_id) && !empty($this->klant_id)) {
            /* Reset this class firsth */
            $this->getDbMarketing($klant_id);

      } if (!empty($klant_id) && !empty($this->klant_id) && ($klant_id != $this->klant_id)){
            /* Different Id reload */
            $this->getDbMarketing($klant_id);
        } else {
            /* Use $id */
        }

        if (!$this->checkId($klant_id, FIELD_MARKETING_KLANT_ID)){
            return FALSE;
        }
        $query = "SELECT `". FIELD_MARKETING_KLANT_ID ."`,`".
                            FIELD_MARKETING_VOORNAAM."`,`".
                            FIELD_MARKETING_ACHTERNAAM."`,`".
                            FIELD_MARKETING_POSTCODE."`,`".
                            FIELD_MARKETING_VOORKEUREN."`,`".
                            FIELD_MARKETING_GEBOORTEDATUM."`,`".
                            FIELD_MARKETING_CREATE_TIME."`".              

                " FROM `".TBL_MARKETING."`".
                " WHERE `". FIELD_MARKETING_KLANT_ID ."` = '". $klant_id ."'";
        $this->dbquery($query);

        if ( $this->checkDbErrors($query) ){
            return FALSE;


            /* Save class data */
           
            $this->klant_id = $klant_id;
            $this->voornaam = $msg_array[FIELD_MARKETING_VOORNAAM];
            $this->achternaam = $msg_array[FIELD_MARKETING_ACHTERNAAM];
            $this->postcode = $msg_array[FIELD_MARKETING_POSTCODE];
            $this->voorkeuren = $msg_array[FIELD_MARKETING_VOORKEUREN];
            $this->geboortedatum = $msg_array[FIELD_MARKETING_GEBOORTEDATUM];
            $this->createtime = $msg_array[FIELD_MARKETING_CREATE_TIME];

            return TRUE;
        }
        return FALSE;

    }


    private function createTable(){
        
        /* Create table MARKETING  */
        $q = "CREATE TABLE IF NOT EXISTS `".DB_NAME."`.`". TBL_MARKETING ."` (".
            "`".FIELD_MARKETING_KLANT_ID."` bigint(10) NOT NULL AUTO_INCREMENT,".
            "`".FIELD_MARKETING_VOORNAAM."` varchar(".LEN_MARKETING_VOORNAAM.") collate latin1_general_cs NOT NULL,".
            "`".FIELD_MARKETING_ACHTERNAAM."` varchar(".LEN_MARKETING_ACHTERNAAM.") collate latin1_general_cs NOT NULL,".
            "`".FIELD_MARKETING_POSTCODE."` varchar(".LEN_MARKETING_POSTCODE.") collate latin1_general_cs NOT NULL,".
            "`".FIELD_MARKETING_VOORKEUREN."` bigint(10) NOT NULL,".
            "`".FIELD_MARKETING_GEBOORTEDATUM."` varchar(".LEN_MARKETING_GEBOORTEDATUM.") collate latin1_general_cs NOT NULL,".
            "`".FIELD_MARKETING_CREATE_TIME."` timestamp NOT NULL default CURRENT_TIMESTAMP,".
            "PRIMARY KEY  (`".FIELD_MARKETING_KLANT_ID."`),".
            "KEY `idx_".FIELD_MARKETING_VOORNAAM."` (`".FIELD_MARKETING_VOORNAAM."`),".
            "KEY `idx_".FIELD_MARKETING_ACHTERNAAM."` (`".FIELD_MARKETING_ACHTERNAAM."`)".
            ") ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs";
              var_dump($q);  
        if ( !$this->dbquery($q)) {
            $this->checkDbErrors($q);
            trigger_error(__FILE__. ' '.__LINE__ . ' Found errors '. __FUNC__ . '<br/>');
            return FALSE;
        }
    }
/*}

 class TestDbMarketing{

    public function TestDbMarketing(){

        echo "******************************************************************<br />";
        $test = new DbMarketing();

        $test->save('HENK', 'De Vries', '4538BA',1, 1952, 1);
        
        //echo "<pre>";
        //var_dump($test->getErrorArray());
        //echo "</pre>";       
        
        //echo "<pre>";
        //var_dump($test);
        //echo "</pre>"; 
        
        
         echo "MARKETING KLANT<br />";
        $test2 = new DbMarketing(5);
        echo "Klant ID: "                       . $test2->getKlant_Id()                . "<BR>";
        echo "Voornaam: "                       . $test2->getVoornaam()                . "<BR>";
        echo "Achternaam : "                    . $test2->getAchternaam()              . "<BR>";  
        echo "Postcode : "                      . $test2->getPostcode()                . "<BR>"; 
        echo "Voorkeuren : "                    . $test2->getVoorkeuren()              . "<BR>"; 
        echo "Geboortedatum : "                 . $test2->getGeboortedatum()           . "<BR>"; 
        
         echo "UPDATE<br />";
        $test3 = new DbMarketing(4);
        $test3->updateKlant('Sjaak', 'de vries',2, 1, 2  );
        
         echo "DELETE<br />";
         $test4 = new DbMarketing(13);
         $test4->deleteKlant();
         var_dump($test4->getErrorArray()); 
        
    }*/
}
?>
