<?php
include_once FILE_DATABASE;
/**
 * Description of db_rooster_tijdblok
 *
 * @author Trinco Ingels 
 * @version 0.1
 */
class DbTijdblok extends Database {
    
    private $tijd_id;
    private $rooster_id;
    private $begintijd;
    private $eindtijd;
    private $taak_id;
    
public function DbTijdblok($tijd_id=''){
        parent::__construct();

        /* Check whether the database already is created */
      if (empty($tijd_id)){
        if( !$this->dbTableExists(TBL_TIJDBLOK)){
            $this->createTable();
        }
        if( !$this->dbTableExists(TBL_TIJDBLOK_TAAK)){
            $this->createTaakTable();
        }
      } else if ( $this->getDbTijdblok($tijd_id) === FALSE ){
          
          return FALSE;
      }
    }
    /**
     * save a new tijdblok entry (rooster)<br />
     *
     * @return bool TRUE | FALSE (Lookup the error array)
     */
   public function save($rooster_id, $begintijd, $eindtijd){
        if (    $this->checkRoosterID($rooster_id)         
           ){

            $query= "INSERT INTO `".TBL_TIJDBLOK.              
                    "`(`".FIELD_ROOSTER_ID . "`,`".
                    FIELD_ROOSTER_TIJDBL_BEGINTIJD. "`,`".
                    FIELD_ROOSTER_TIJDBL_EINDTIJD. "`)".
                    " VALUES ('".$rooster_id."','".
                    $begintijd."','".
                    $eindtijd."')";

            $this->dbquery($query);
            if($this->checkDbErrors($query)){
                return FALSE;
            }

            /* Update class attributes */
            $this->tijd_id = mysql_insert_id($this->connection);
            $this->rooster_id = $rooster_id;
            $this->begintijd = $begintijd;
            $this->eindtijd = $eindtijd;

        } else {
            return FALSE;
        }
        return TRUE;
    }
    /** Retrieve tijd_id
     * @param <type> $tijd_id
     * @return int tijd_id from tijdblok
     */   
    public function getTijdId() {
    if (!empty($this->tijd_id)){
            return $this->tijd_id;
        }
        return FALSE;
    }
    /** Retrieve rooster_id
     * @param <type> $id
     * @return int Id from rooster
     */    
    public function getRoosterid() {
        return $this->rooster_id;
    }
    /** Retrieve begintijd
     * @param <type> $begintijd
     * @return timestamp begintijd from tijdblok
     */
    public function getBegintijd() {
        return $this->begintijd;
    }
    /** Retrieve eindtijd
     * @param <type> $eindtijd
     * @return timestamp eindtijd from tijdblok
     */    
    public function getEindtijd() {
        return $this->eindtijd;
    }
    /**
     * Collect class data and return.<br />
     * When a different or new id is provided the class vars
     * are loaded from the database.
     *
     * @return bool  FALSE If no valid tijd_id was found
     * @return array class return_array.
     */    
    public function getTijdblok($tijd_id=''){
        if( empty($tijd_id) && empty($this->tijd_id)){
            /* Both empty is error */
               $this->setError(TXT_ERROR. TXT_NO_VALID_MSG_ID);
            return FALSE;

        } else if( !empty($tijd_id) && empty($this->tijd_id)){
            /* New id load */
            $this->getDbTijdblok($tijd_id);

        } if (!empty($tijd_id) && !empty($this->tijd_id) && ($tijd_id != $this->tijd_id)){
            /* Different Id reload */
            $this->getDbTijdblok($tijd_id);
        } else {
            /* Valid class id */
        }

        if ( !$this->checkTijdId($this->tijd_id) ){
            /* Finaly still no valid msg id */
            return FALSE;
        }
        $return_array = array();
        $return_array['tijd_id']         = $this->tijd_id;
        $return_array['rooster_id']  = $this->rooster_id;
        $return_array['begintijd'] = $this->begintijd;
        $return_array['eindtijd']      = $this->eindtijd;

        return $return_array;
    }
    /**
     * Update a tijdblok entry (rooster) by given an ID<br />
     *
     * @return bool TRUE | FALSE (Lookup the error array)
     */
    public function updateTijdblok($rooster_id, $begintijd, $eindtijd){
        if (    $this->checkRoosterId($rooster_id) &&
                $this->checkId($this->tijd_id, FIELD_ROOSTER_ID)){

            $query = "UPDATE `". DB_NAME ."`.`".TBL_TIJDBLOK .
                     "` SET `".FIELD_ROOSTER_ID."` = '".$rooster_id."',`".
                               FIELD_ROOSTER_TIJDBL_BEGINTIJD."` = '".$this->begintijd."',`".
                               FIELD_ROOSTER_TIJDBL_EINDTIJD."` = '".$this->eindtijd.
                     "' WHERE `". TBL_TIJDBLOK ."`.`".FIELD_ROOSTER_TIJDBL_TIJD_ID."` ='".$this->tijd_id."'";
            $result = $this->dbquery($query);
            return ($this->checkDbErrors($query));
        }
        return FALSE;
    }
    /**
     *
     * Delete a tijdblok entry (rooster)by given an ID<br />
     *
     * @return bool TRUE | FALSE (Lookup the error array)
     */  
    public function deleteTijdblok(){
        if (!empty($this->tijd_id)){
        $query = " DELETE FROM `". DB_NAME ."`.`".TBL_TIJDBLOK."`".
                 " WHERE `". TBL_TIJDBLOK ."`.`".FIELD_ROOSTER_TIJDBL_TIJD_ID."` ='".$this->tijd_id."' ";
        $result = mysql_query($query);
            return ($this->checkDbErrors($query));
        }
            $this->setError(TXT_ERROR. TXT_NO_VALID_TIJDBLOK_ID);
    }
    /**
     *
     * @param int $tijd_id Id that is checked in the DB
     * @return bool TRUE if exists | FALSE
     */
    public function idExists($tijd_id){
        if ( !$this->checkId($tijd_id, FIELD_ROOSTER_TIJDBL_TIJD_ID) ){
            return FALSE;
        }
        
        $query = "SELECT `". FIELD_ROOSTER_TIJDBL_TIJD_ID ."` FROM `". TBL_TIJDBLOK .
            "` WHERE `". FIELD_ROOSTER_TIJDBL_TIJD_ID ."`='". $tijd_id."'";
        $result = $this->dbquery($query);
         return ($this->checkDbErrors($query));
        if ($this->dbNumRows() < 1){
            return FALSE;
        }
        return TRUE;
    }
    /**
     *
     * Add taak_id in cross tabel
     *
     * @param id $taak_id check in dbRoosterTaak
     * @return bool TRUE | FALSE (Lookup the error array)
     */    
    public function voegTaakToe($taak_id){
        //Controleer taak id
        $dbtaak = new dbRoosterTaak();

        if($dbtaak->idExists($taak_id)){
        //Maak query
            $query = "INSERT INTO `".TBL_TIJDBLOK_TAAK.
                  "`(`".FIELD_ROOSTER_TIJDBL_TIJD_ID. "`,`".
                        FIELD_ROOSTER_TAAK_ID."`)".
                    " VALUES ('".$this->tijd_id."',
                              '".$taak_id.      "')";
            $this->dbquery($query);
        echo $taak_id . "bestaat";
        } 
        $this->setError(TXT_ERROR. TXT_NO_VALID_TAAK_ID);
    }
    /**
     *
     * Check the provided begintijd
     * @param timestamp $begintijd A valid timestamp
     * @return bool TRUE (Ok) | FALSE (Nok)
     */
    private function checkBegintijd($begintijd) {
        if ( !$this->checkBegintijd($begintijd)){
            return FALSE;
        }
    }
    /**
     *
     * Check the provided eindtijd 
     * @param timestamp $eindtijd A valid timestamp
     * @return bool TRUE (Ok) | FALSE (Nok)
     */    
    private function checkEindtijd($eindtijd) {
        if ( !$this->checkEindtijd($eindtijd)){
            return FALSE;
        }
        return TRUE;   
    }
    /**
     *
     * Check the provided id 
     * @param int $id A rooster Id
     * @return bool TRUE (Ok) | FALSE (Nok)
     */    
    private function checkRoosterId($rooster_id){
        if ( !$this->checkId($rooster_id, FIELD_ROOSTER_ID)){
            return FALSE;
        }
        return TRUE;
    }
     /**
     *
     * Check the provided tijd_id 
     * @param int $tijd_id A tijd Id
     * @return bool TRUE (Ok) | FALSE (Nok)
     */   
        private function checkTijdId($tijd_id){
        if ( !$this->checkId($tijd_id, FIELD_ROOSTER_TIJDBL_TIJD_ID)){
            return FALSE;
        }
        return TRUE;
    }
    /**
     *  Class T reset:<br />
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
        $this->tijd_id = '';
        $this->rooster_id = '';
        $this->begintijd = time();
        $this->eindtijd = time();


    }
    /**
     *
     * Load tijdblok with $id from database.<br />
     *  When a different id is provided, the class is reset
     *  and loaded with the new id.
     *
     * @param int $id tijdblok id.
     * @return bool TRUE if class data is filled or
     *              FALSE if error found (Check error array)
     */
    private function getDbTijdblok($tijd_id =''){
        if (empty($tijd_id) && !empty($this->tijd_id)) {
            $id = $this->tijd_id;

        } else if (!empty($tijd_id) && !empty($this->tijd_id)) {
            /* Reset this class firsth */
            $this->reset();

        } else if (empty($tijd_id) && empty($this->tijd_id)) {
            /* Both empty -> Error */
            setError( TXT_ERROR. TXT_NO_VALID_TIJD_ID);
            return FALSE;
        } else {
            /* Use $id */
        }
        
        if (!$this->checkId($tijd_id, FIELD_ROOSTER_TIJDBL_TIJD_ID)){
            return FALSE;
        }
        $query = "SELECT `". FIELD_ROOSTER_TIJDBL_TIJD_ID ."`,`".
                            FIELD_ROOSTER_ID."`,`".     
                            FIELD_ROOSTER_TIJDBL_BEGINTIJD."`,`".                           
                            FIELD_ROOSTER_TIJDBL_EINDTIJD."`".

                " FROM `".TBL_TIJDBLOK."`".
                " WHERE `". FIELD_ROOSTER_TIJDBL_TIJD_ID ."` = '". $tijd_id ."'";
        $this->dbquery($query);
        if ( $this->checkDbErrors($query) ){
            return FALSE;
            
        }
        $rooster_array = $this->dbFetchArray();
        if ($rooster_array !== FALSE){

            /* Save class data */
            $this->tijd_id = $tijd_id;
            $this->rooster_id = $rooster_array[FIELD_ROOSTER_ID];
            $this->begintijd = $rooster_array[FIELD_ROOSTER_TIJDBL_BEGINTIJD];
            $this->eindtijd = $rooster_array[FIELD_ROOSTER_TIJDBL_EINDTIJD];

            
            return TRUE;
        }
        return FALSE;

    }
    /**
     * When table not exists from tijdblok
     * 
     * @return bool TRUE create this table
     *              FALSE run code
     * 
     */    
   private function createTable(){
        /* Table Tijdblok */    
       $query = "CREATE TABLE `".DB_NAME."`.`".TBL_TIJDBLOK."` (".
            "`".FIELD_ROOSTER_TIJDBL_TIJD_ID."` bigint( 10 ) NOT NULL ,".
            "`".FIELD_ROOSTER_ID."` bigint( 10 ) NOT NULL ,".
            "`".FIELD_ROOSTER_TIJDBL_BEGINTIJD."` timestamp NOT NULL,".
            "`".FIELD_ROOSTER_TIJDBL_EINDTIJD."` timestamp NOT NULL,".
            "PRIMARY KEY ( `".FIELD_ROOSTER_TIJDBL_TIJD_ID."` )".
            ") ENGINE = MYISAM ";
 
        if ( !$this->dbquery($query)) {
            $this->checkDbErrors($query);
            return FALSE;
        }
    }
    /**
     * When table not exists from Tijdblok/Taak
     * 
     * @return bool TRUE create this table
     *              FALSE run code
     * */    
    private function createTaakTable(){
        /* Table tijdblok/taak (crosstabel) */    
       $query = "CREATE TABLE `".DB_NAME."`.`".TBL_TIJDBLOK_TAAK."` (".
            "`".FIELD_ROOSTER_TAAK_ID."` bigint( 10 ) NOT NULL ,".
            "`".FIELD_ROOSTER_TIJDBL_TIJD_ID."` bigint( 10 ) NOT NULL ,".
            "KEY `idx_".FIELD_ROOSTER_TAAK_ID."` (`".FIELD_ROOSTER_TAAK_ID."`),".
            "KEY `idx_".FIELD_ROOSTER_TIJDBL_TIJD_ID."` (`".FIELD_ROOSTER_TIJDBL_TIJD_ID."`)".
            ") ENGINE = MYISAM ";
        if ( !$this->dbquery($query)) {
            $this->checkDbErrors($query);
            return FALSE;
        }
    }
}
class TestDbTijdblok{

    public function TestDbTijdblok(){

        echo "Test 1 DbTijdblok: new klasse &amp;&amp; save<br />";
        $test = new DbTijdblok();

        $test->save(1, '2011-12-07 00:00:00', '2011-12-07 00:00:00');

        echo "Test 2 DbTijdblok: Haalt waarden uit de database a.d.h.v. ID.<br />";
        $test2 = new DbTijdblok(1);

        echo "Tijd ID: "      . $test2->getTijdId()       . "<BR>";
        echo "Rooster ID: "   . $test2->getRoosterid()    . "<BR>";
        echo "Begintijd: "    . $test2->getBegintijd() . "<BR>";
        echo "Eindtijd: "     . $test2->getEindtijd()   . "<BR>";

        echo "<pre>";
        echo "</pre>";
        
        if($test2->getErrorNr() > 0 ){
        $error=$test2->getErrorArray();

        }
        
        echo "<pre>";

        echo "</pre>";
           
        echo "Test 3 DbTijdblok: Update waarden in de database a.d.h.v. ID.";
        $test3 = new DbTijdblok(1);

        $test3->updateTijdblok(3, time(), '2011-11-29 13:48:40');
        
        echo "<br>";

        if($test3->getErrorNr() > 0 ){
        $error=$test3->getErrorArray();

        }        
        echo "<pre>";
        echo "</pre>";
        
        echo "Test 4 DbTijdblok: Delete waarden in de database a.d.h.v. ID.";
        echo "<BR>";
        $test4 = new DbTijdblok(3);
        
        $test4->deleteTijdblok();
        echo "<pre>";;
        echo "</pre>";
        
        if($test4->getErrorNr() > 0 ){
        $error=$test4->getErrorArray();
        }
        
        $test5 = new DbTijdblok(2);
        $taak_id = 1;
        $test5->voegTaakToe($taak_id);
      
    }
}


?>
    