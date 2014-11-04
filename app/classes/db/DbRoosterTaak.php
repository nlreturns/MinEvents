<?php
namespace minevents\app\classes\db;
/**
 * Description of db_rooster_taak
 *
 * @author Trinco Ingels 
 * @version 0.1
 */
class DbRoosterTaak extends database {
        
    private $taak_id;
    private $taak_beschrijving;
    private $tijdid;
    
    public function DbRoosterTaak($taak_id=''){
        parent::__construct();

        /* Check whether the database already is created */
        if (empty($taak_id)){
            if( !$this->dbTableExists(TBL_TAAK)){
                $this->createTable();
            }
        }else if ( $this->getDbRoosterTaak($taak_id) === FALSE){
            
            return FALSE;
        }
    }
    /**
     * Save a new taak entry (rooster)<br />
     *
     * @return bool TRUE | FALSE (Lookup the error array)
     */    
   public function save($taak_beschrijving){
        if (    $this->checkTaakDesc($taak_beschrijving)    ){

            $query= "INSERT INTO `".TBL_TAAK.              
                    "`(`".FIELD_ROOSTER_TAAK_DESC . "`)".
                    " VALUES ('".$this->dbInString($taak_beschrijving)."')";

            $this->dbquery($query);
            var_dump($query);
            if($this->checkDbErrors($query)){
                return FALSE;
            }

            /* Update class attributes */
            $this->id = mysql_insert_id($this->connection);
            $this->taak_beschrijving = $taak_beschrijving;

        } else {
            return FALSE;
        }
        return TRUE;
    }
    /** Retrieve taak_id
     * @param <type> $taak_id
     * @return int taak_id from taak
     */     
    public function getTaakId() {
    if (!empty($this->taak_id)){
            return $this->taak_id;
        }
        return FALSE;
    } 
    /** Retrieve taak_id
     * @param <type> $taak_id
     * @return int taak_id from taak
     */     
    public function getTaakBeschrijving() {
        return $this->taak_beschrijving;
    }
    /**
     * Update a taak entry (rooster) by given an ID<br />
     *
     * @return bool TRUE | FALSE (Lookup the error array)
     */    
    public function updateTaak($taak_beschrijving){
        if (    $this->checkTaakDesc($taak_beschrijving) &&
                $this->checkId($this->taak_id, FIELD_ROOSTER_TAAK_ID)){

            $query = "UPDATE `". DB_NAME ."`.`".TBL_TAAK .
                     "` SET `".FIELD_ROOSTER_TAAK_DESC."` = '".$taak_beschrijving.
                     "' WHERE `". TBL_TAAK ."`.`".FIELD_ROOSTER_TAAK_ID."` ='".$this->taak_id."'";
            $result = $this->dbquery($query);
            return ($this->checkDbErrors($query));
        }
        $this->setError(TXT_ERROR. TXT_NO_VALID_ROOSTER_ID);
    }
    /**
     * Delete a taak entry (rooster) by given an ID<br />
     *
     * @return bool TRUE | FALSE (Lookup the error array)
     */
    public function deleteTaak(){
        if (!empty($this->taak_id)){
        $query = " DELETE FROM `". DB_NAME ."`.`".TBL_TAAK."`".
                 " WHERE `". TBL_TAAK ."`.`".FIELD_ROOSTER_TAAK_ID."` ='".$this->taak_id."' ";
        $result = mysql_query($query);
            return ($this->checkDbErrors($query));
        }
            $this->setError(TXT_ERROR. TXT_NO_VALID_ROOSTER_ID);
    }
    /**
     *
     * @param int $taak_id Id that is checked in the DB
     * @return bool TRUE if exists | FALSE
     */
    public function idExists($taak_id){
        if ( !$this->checkId($taak_id, FIELD_ROOSTER_TAAK_ID) ){
            return FALSE;
        }
        
        $query = "SELECT `". FIELD_ROOSTER_TAAK_ID ."` FROM `". TBL_TAAK .
            "` WHERE `". FIELD_ROOSTER_TAAK_ID ."`='". $taak_id."'";
        $result = $this->dbquery($query);
            return ($this->checkDbErrors($query));
        if ($this->dbNumRows() < 1){
            return FALSE;
        }
        return TRUE;
    }
    /**
     *
     * Add tijd_id in cross tabel
     *
     * @param id $tijd_id check in dbrooster_tijdblok
     * @return bool TRUE | FALSE (Lookup the error array)
     */     
        public function voegTijdToe($tijd_id){
        //Controleer taak id
        $dbtijd = new dbTijdblok();

        if($dbtijd->idExists($tijd_id)){
        //Maak query
            $query = "INSERT INTO `".TBL_TIJDBLOK_TAAK.
                  "`(`".FIELD_ROOSTER_TIJDBL_TIJD_ID. "`,`".
                        FIELD_ROOSTER_TAAK_ID."`)".
                    " VALUES ('".$tijd_id."',
                              '".$this->taak_id.      "')";
            $this->dbquery($query);
            return ($this->checkDbErrors($query));
        echo $tijd_id . "bestaat";
        } 
        $this->setError(TXT_ERROR. TXT_NO_VALID_TIJD_ID);
    }
    /**
     *
     * Check the provided description
     * @param string $text A valid string
     * @return bool TRUE (Ok) | FALSE (Nok)
     */    
    private function checkTaakDesc($text){
        if (    empty($text)            ||
                (!is_string($text))     ||
                (strlen($text) > LEN_ROOSTER_TAAK_DESC)) {

            $this->setError( TXT_ERROR_EMPTY . FIELD_ROOSTER_TAAK_DESC);
            trigger_error(__FILE__. ' '.__LINE__ . ' Found errors in ['. $text . '] '. __FUNCTION__ . '<br/>');
            return FALSE;
        }
        return TRUE;
    }
    /**
     *  Class Taak reset:<br />
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
        $this->taak_id = '';
        $this->taak_beschrijving = '';

    }
    /**
     *
     * Load taak with $id from database.<br />
     *  When a different id is provided, the class is reset
     *  and loaded with the new id.
     *
     * @param int $id tijdblok id.
     * @return bool TRUE if class data is filled or
     *              FALSE if error found (Check error array)
     */
 private function getDbRoosterTaak($taak_id =''){
        if (empty($taak_id) && !empty($this->taak_id)) {
            $id = $this->taak_id;

        } else if (!empty($taak_id) && !empty($this->taak_id)) {
            /* Reset this class firsth */
            $this->reset();

        } else if (empty($taak_id) && empty($this->taak_id)) {
            /* Both empty -> Error */
            setError( TXT_ERROR. TXT_NO_VALID_TAAK_ID);
            return FALSE;
        } else {
            /* Use $id */
        }
        
        if (!$this->checkId($taak_id, FIELD_ROOSTER_TAAK_ID)){
            return FALSE;
        }
        $query = "SELECT `". FIELD_ROOSTER_TAAK_ID ."`,`".
                            FIELD_ROOSTER_TAAK_DESC."`".     

                " FROM `".TBL_TAAK."`".
                " WHERE `". FIELD_ROOSTER_TAAK_ID ."` = '". $taak_id ."'";
        $this->dbquery($query);
        if ( $this->checkDbErrors($query) ){
            return FALSE;
            
        }
        $rooster_array = $this->dbFetchArray();
        if ($rooster_array !== FALSE){

            /* Save class data */
            $this->taak_id = $taak_id;
            $this->taak_beschrijving = $rooster_array[FIELD_ROOSTER_TAAK_DESC];

            
            return TRUE;
        }
        return FALSE;

    }
    /**
     * When table not exists from taak
     * 
     * @return bool TRUE create this table
     *              FALSE run code
     * 
     */   
   private function createTable(){
        /* Table Persoonsgegevens */    
       $query = "CREATE TABLE `".DB_NAME."`.`".TBL_TAAK."` (".
            "`".FIELD_ROOSTER_TAAK_ID."` bigint( 10 ) NOT NULL ,".
            "`".FIELD_ROOSTER_TIJDBL_TIJD_ID."` bigint( 10 ) NOT NULL ,".
            "`".FIELD_ROOSTER_TAAK_DESC."` varchar(".LEN_ROOSTER_TAAK_DESC.") collate latin1_general_cs NOT NULL,".
            "PRIMARY KEY ( `".FIELD_ROOSTER_TAAK_ID."` )".
            ") ENGINE = MYISAM ";
        
        if ( !$this->dbquery($query)) {
            $this->checkDbErrors($query);
            return FALSE;
        }
    }
}

class TestDbRoosterTaak{
    
    public function TestDbRoosterTaak(){
        
        echo "Test 1 DbRoosterTaak: new klasse &amp;&amp; save<br />";
        $test = new DbRoosterTaak();


        $test->save('Vaatwasser leegmaken');

        
        echo "Test 2 DbRoosterTaak: Haalt waarden uit de database a.d.h.v. ID.<br />";
        $test2 = new DbRoosterTaak(1);

        echo "Taak ID: "             . $test2->getTaakId()              . "<BR>";
        echo "Taak Beschrijving: "   . $test2->getTaakBeschrijving()    . "<BR>";

        if($test2->getErrorNr() > 0 ){
        $error=$test2->getErrorArray();
        }
        
         echo "Test 3 DbRoosterTaak: Update waarden in de database a.d.h.v. ID.";
        $test3 = new DbRoosterTaak(1);

        $test3->updateTaak('Micha moet geexecuteerd worden ');
        
        echo "<br>";
        if($test3->getErrorNr() > 0 ){
        $error=$test3->getErrorArray();
        }        
        
        echo "Test 4 DbRoosterTaak: Delete waarden in de database a.d.h.v. ID.";
        echo "<BR>";
        $test4 = new DbRoosterTaak(3);
        
        $test4->deleteTaak();

        if($test4->getErrorNr() > 0 ){
        $error=$test4->getErrorArray();
        }
        
        echo "Test5 DbRoosterTaak: Koppel tabel";
        echo "<BR>";
        $test5 = new DbRoosterTaak(1);
        $tijd_id = 1;
        $test5->voegTijdToe($tijd_id);
    }
}
?>
