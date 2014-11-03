<?php
/*First include the required files*/
include_once FILE_DATABASE;
require_once FILE_DB_ROOSTER_TIJDBLOK;
require_once FILE_DB_ROOSTER_STATUS;
require_once FILE_DB_ROOSTER_TAAK;
/**
 * Description of db_rooster
 *
 * @author Trinco Ingels
 * @version 0.1
 */

class DbRooster extends Database {
    
    private $rooster_id;
    private $createtime;
    private $aanmaakpersoon;
    private $roosterstatus;
    private $tekst;
    private $roosterstatus_id;
    
    public function DbRooster ($rooster_id=''){
        parent::__construct();

        if (empty($rooster_id)){
            /* Check whether the database already is created */
            if( !$this->dbTableExists(TBL_ROOSTER)){
                $this->createTable();
            }
            if( !$this->dbTableExists(TBL_TIJDBLOK)){
                /* Create by calling constructor */
               $msg_type = new DbTijdblok();
               unset( $msg_type );
            }
			if( !$this->dbTableExists(TBL_TIJDBLOK_TAAK)){
                /* Create by calling constructor */
               $msg_type = new DbTijdblok();
               unset( $msg_type );
            }
            if( !$this->dbTableExists(TBL_ROOSTERSTATUS)){
                /* Create by calling constructor */
                $msg_type = new DbRoosterStatus();
                unset( $msg_type );
            }
            if( !$this->dbTableExists(TBL_TAAK)){
                /* Create by calling constructor */
                $msg_type = new DbRoosterTaak();
                unset( $msg_type );     
            }
        } else if ( $this->getDbRooster($rooster_id) === FALSE ){
                /** Update class with db info **/
                return FALSE;
        }
    }
    public function save($roosterstatus_id, $roosterstatus, $tekst, $aanmaakpersoon){

        /* Status shall be looked up and changed for Id */
        $db_status = new DbRoosterStatus();

        $status_id = (int)($db_status->getIdByName($roosterstatus));

        if (    $this->checkRoosterStatusId($status_id)               &&
                $this->checkRoosterStatus($roosterstatus)               &&
                $this->checkTekst($tekst)               &&
                $this->checkAanmaakpersoon($aanmaakpersoon)    ){

            $query= "INSERT INTO `".TBL_ROOSTER.
                    "`(`". FIELD_ROOSTER_STATUS_ID."`,`".
                    FIELD_ROOSTER_STATUS.     "`,`".
                    FIELD_ROOSTER_TEXT.     "`,`".                    
                    FIELD_ROOSTER_AANMAAK_PERSOON . "`)".
                    " VALUES ('".$status_id."','".                  
                    $this->dbInString($roosterstatus)."','".                    
                    $this->dbInString($tekst)."','". 
                    $this->dbInString($aanmaakpersoon)."')";

            $this->dbquery($query);
            if($this->checkDbErrors($query)){
                return FALSE;
            }

            /* Update class attributes */
            $this->rooster_id = mysql_insert_id($this->connection);
            $this->roosterstatus_id = $roosterstatus_id;
            $this->roosterstatus = $roosterstatus;
            $this->tekst = $tekst;
            $this->aanmaakpersoon = $aanmaakpersoon;
            $this->createtime = $this->getCreateTime();

        } else {
            return FALSE;
        }
        return TRUE;
    }
    
    /** Retrieve rooster_id
     * @param <type> $id
     * @return int Id from rooster
     */
    public function getRoosterId(){
        if(!empty($this->rooster_id)){
            return $this->rooster_id;
        }return FALSE;
        $this->setError(TXT_ERROR. TXT_NO_VALID_ROOSTER_ID);
    }
    
    /** Retrieve aanmaakpersoon
     * @param <type> $aanmaakpersoon
     * @return string aanmaakpersoon from rooster
     */
    public function getAanmaakpersoon() {
        return $this->aanmaakpersoon;
    }
    
    /** Retrieve roosterstatus
     * @param <type> $roosterstatus
     * @return string roosterstatus from rooster
     */
    public function getRoosterStatus(){
        return $this->roosterstatus;
    }
    /** Retrieve tekst
     * @param <type> $tekst
     * @return string tekst from rooster
     */
    public function getTekst(){
        return $this->tekst;
    }
    /** Retrieve creatietijd
     * @param <type> $creatietijd
     * @return timestamp creatietijd from rooster
     */
    public function getCreatietijd(){
        return $this->createtime;
    }
    /** Retrieve roosterStatusId
     * @param <type> $roosterstatus_id;
     * @return int rooster_status_id from rooster
     */
    public function getRoosterStatusId(){
        return $this->roosterstatus_id;
    }
    /**
     *
     * Collect class data and return.<br />
     * When a different or new id is provided the class vars
     * are loaded from the database.
     *
     * @return bool  FALSE If no valid rooster_id was found
     * @return array class return_array.
     */
    public function getRooster($rooster_id=''){
        if( empty($rooster_id) && empty($this->rooster_id)){
            /* Both empty is error */
               $this->setError(TXT_ERROR. TXT_NO_VALID_ROOSTER_ID);
            return FALSE;

        } else if( !empty($rooster_id) && empty($this->rooster_id)){
            /* New id load */
            $this->getDbRooster($rooster_id);

        } if (!empty($rooster_id) && !empty($this->rooster_id) && ($rooster_id != $this->rooster_id)){
            /* Different Id reload */
            $this->getDbRooster($rooster_id);
        } else {
            /* Valid class id */
        }

        if ( !$this->checkRoosterId($this->rooster_id) ){
            /* Finaly still no valid msg id */
            return FALSE;
        }
        $return_array = array();
        $return_array['rooster_id']         = $this->rooster_id;
        $return_array['roosterstatus_id']  = $this->roosterstatus_id;
        $return_array['roosterstatus']      = $this->roosterstatus;
        $return_array['tekst']              = $this->tekst;
        $return_array['creatietijd']        = $this->creatietijd;
        $return_array['aanmaakpersoon']     = $this->aanmaakpersoon;

        return $return_array;
    }

    /**
     * The first status is always new,
     * but the Id does change.
     * Hence this function...
     * @return bool FALSE | int Id from the new status
     */
    public function getNewStatusId(){
        $db_status = new DbRoosterStatus();
        return $db_status->getNewStatusId();
    }
    /**
     *
     * @param int $id Id that is checked in the DB
     * @return bool TRUE if exists | FALSE
     */
    public function roosterIdExists($rooster_id){
        if ( !$this->checkId($rooster_id, FIELD_ROOSTER_ID) ){
            return FALSE;
        }
        
        $query = "SELECT `". FIELD_ROOSTER_ID ."` FROM `". TBL_ROOSTER .
            "` WHERE `". FIELD_ROOSTER_ID ."`='". $rooster_id."'";
        $result = $this->dbquery($query);
        
        if ( !$this->checkDbErrors($query)){

            return FALSE;
        }
        return TRUE;
    }
    /**
     *
     * Update a rooster entry (rooster) by given an ID<br />
     *
     * @return bool TRUE | FALSE (Lookup the error array)
     */
    public function updateRooster($roosterstatus_id, $roosterstatus, $tekst, $aanmaakpersoon){
        
        if (!empty($this->rooster_id)){
            
            if (    $this->checkRoosterStatusId($roosterstatus_id) &&
                    $this->checkRoosterstatus($roosterstatus) &&
                    $this->checkTekst($tekst) &&
                    $this->checkAanmaakpersoon($aanmaakpersoon)
                    ){

                $query = "UPDATE `". DB_NAME ."`.`".TBL_ROOSTER .
                         "` SET `".FIELD_ROOSTER_STATUS_ID."` = '".$roosterstatus_id."',`".
                                  FIELD_ROOSTER_STATUS."` = '".$this->dbInString($roosterstatus)."',`".
                                  FIELD_ROOSTER_TEXT."` = '".$this->dbInString($tekst)."',`".
                                  FIELD_ROOSTER_AANMAAK_PERSOON."` = '".$this->dbInString($aanmaakpersoon).
                         "' WHERE `". TBL_ROOSTER ."`.`".FIELD_ROOSTER_ID."` ='".$this->rooster_id."'";
                $result = $this->dbquery($query);
                 return ($this->checkDbErrors($query));
            }
            return FALSE;
        }else{
            $this->setError(TXT_ERROR. TXT_NO_VALID_ROOSTER_ID);
            
            
        }
    }

    /**
     *
     * Delete the description of a rooster entry (rooster)<br />
     *
     * @param string $desc New description of the rooster
     * @return bool TRUE | FALSE (Lookup the error array)
     */
    public function deleteRooster(){
        
        if (!empty($this->rooster_id)){
        $query = " DELETE FROM `". DB_NAME ."`.`".TBL_ROOSTER."`".
                 " WHERE `". TBL_ROOSTER ."`.`".FIELD_ROOSTER_ID."` ='".$this->rooster_id."' ";
        $result = mysql_query($query);
                 echo "Entry is verwijderd!";
		 return ($this->checkDbErrors($query));
        }
            $this->setError(TXT_ERROR. TXT_NO_VALID_ROOSTER_ID);

    }
    
    /**
     *
     * @return Timestamp | empty string ('')
     */
    private function getCreateTime(){

        $query = "SELECT `". FIELD_MSGBRD_CREATE_TIME ."` FROM `". TBL_MESSAGEBOARD .
            "` WHERE `". FIELD_MSGBRD_ID ."`='". $this->rooster_id."'";
        $result = $this->dbquery($query);

        if ( !$this->checkDbErrors($query)){

            $row_array = $this->dbFetchArray();
            return $row_array[FIELD_MSGBRD_CREATE_TIME];
        }
        return '';
    }
    
    /**
     *
     * Check the provided id 
     * @param int $id A roosterStatus Id
     * @return bool TRUE (Ok) | FALSE (Nok)
     */
    private function checkRoosterStatusId($roosterstatus_id){
        if ( !$this->checkId($roosterstatus_id, FIELD_ROOSTER_STATUS_ID)){
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
     * Check the provided tekst
     * @param string $tekst A valid string
     * @return bool TRUE (Ok) | FALSE (Nok)
     */
   private function checkTekst($tekst){
        if (    empty($tekst)   ){
           $this->setError( TXT_ERROR .  FIELD_ROOSTER_TEXT);

        } else if ( !is_string($tekst) ) {
           $this->setError( TXT_ERROR_WRONG_VAR_TYPE. FIELD_ROOSTER_TEXT );
        } else if ( strlen($tekst) > LEN_ROOSTER_TEXT ){
            $this->setError( TXT_ERROR_VAR_SIZE . ' '. FIELD_ROOSTER_TEXT);
            trigger_error(__FILE__. ' '.__LINE__ . ' Found errors '. __FUNCTION__ . '<br/>');
            return FALSE;
        }
        return TRUE;
    }
    /**
     *
     * Check the provided aanmaakpersoon
     * @param string $aanmaakpersoon A valid string
     * @return bool TRUE (Ok) | FALSE (Nok)
     */
    private function checkAanmaakpersoon($aanmaakpersoon){
        if (    empty($aanmaakpersoon)   ){
           $this->setError( TXT_ERROR .  FIELD_ROOSTER_AANMAAK_PERSOON);

        } else if ( !is_string($aanmaakpersoon) ) {
           $this->setError( TXT_ERROR_WRONG_VAR_TYPE. FIELD_ROOSTER_AANMAAK_PERSOON );
        } else if ( strlen($aanmaakpersoon) > LEN_ROOSTER_AANMAAK_PERSOON ){
            $this->setError( TXT_ERROR_VAR_SIZE . ' '. FIELD_ROOSTER_AANMAAK_PERSOON);
            trigger_error(__FILE__. ' '.__LINE__ . ' Found errors '. __FUNCTION__ . '<br/>');
            return FALSE;
        }
        return TRUE;
    } 
    /**
     *
     * Check the provided roosterstatus
     * @param string $roosterstatus A valid string
     * @return bool TRUE (Ok) | FALSE (Nok)
     */
    private function checkRoosterstatus( $roosterstatus ){
        if ( strlen($roosterstatus) > LEN_ROOSTER_STATUS){
            $this->setError( TXT_ERROR_VAR_SIZE . ' '. FIELD_ROOSTER_STATUS);
            return FALSE;
        }
        return TRUE;
    }

    /**
     *  Class Rooster reset:<br />
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
        $this->rooster_id = '';
        $this->roosterstatus_id = 0;
        $this->roosterstatus = 'reset';
        $this->tekst = 'Voorbeeld';
        $this->createtime = $this->getCreateTime();
        $this->aanmaakpersoon = 'Admin';

    }

    /**
     *
     * Load rooster with $id from database.<br />
     *  When a different id is provided, the class is reset
     *  and loaded with the new id.
     *
     * @param int $id rooster id.
     * @return bool TRUE if class data is filled or
     *              FALSE if error found (Check error array)
     */
    private function getDbRooster($rooster_id =''){

        if (empty($rooster_id) && !empty($this->rooster_id)) {
            $rooster_id = $this->rooster_id;

        } else if (!empty($rooster_id) && !empty($this->rooster_id)) {
            /* Reset this class first */
            $this->reset();

        } else if (empty($rooster_id) && empty($this->rooster_id)) {
            /* Both empty -> Error */
            return FALSE;
        } else {
            /* Use $id */
        }

        if (!$this->checkId($rooster_id, FIELD_ROOSTER_ID)){
            return FALSE;
        }
        $query = "SELECT `". FIELD_ROOSTER_ID ."`,`".
                            FIELD_ROOSTER_STATUS_ID."`,`".                           
                            FIELD_ROOSTER_STATUS."`,`".
                            FIELD_ROOSTER_TEXT."`,`".
                            FIELD_ROOSTER_CREATE_TIME."`,`".
                            FIELD_ROOSTER_AANMAAK_PERSOON."`".

                " FROM `".TBL_ROOSTER."`".
                " WHERE `". FIELD_ROOSTER_ID ."` = '". $rooster_id ."'";
        $this->dbquery($query);
        if ( $this->checkDbErrors($query) ){
            return FALSE;
        }
        $rooster_array = $this->dbFetchArray();
        
        if ($rooster_array !== FALSE){

            /* Save class data */
            $this->rooster_id = $rooster_id;
            $this->roosterstatus_id = $rooster_array[FIELD_ROOSTER_STATUS_ID];
            $this->roosterstatus = $rooster_array[FIELD_ROOSTER_STATUS];
            $this->tekst = $rooster_array[FIELD_ROOSTER_TEXT];
            $this->createtime = $rooster_array[FIELD_ROOSTER_CREATE_TIME];
            $this->aanmaakpersoon = $rooster_array[FIELD_ROOSTER_AANMAAK_PERSOON];
            
            return TRUE;
        }
        return FALSE;

    }
    /**
     * When table not exists from rooster
     * 
     * @return bool TRUE create this table
     *              FALSE run code
     * */

    private function createTable(){
        
        /* Table Messageboard */
        $q = "CREATE TABLE IF NOT EXISTS `".DB_NAME."`.`". TBL_ROOSTER ."` (".
            "`".FIELD_ROOSTER_ID."` bigint(10) NOT NULL AUTO_INCREMENT,".
            "`".FIELD_ROOSTER_STATUS_ID."` bigint(10) NOT NULL,".
            "`".FIELD_ROOSTER_STATUS."` varchar(".LEN_ROOSTER_STATUS.") collate latin1_general_cs NOT NULL,".
            "`".FIELD_ROOSTER_TEXT."` varchar(".LEN_ROOSTER_TEXT.") collate latin1_general_cs NOT NULL,".                
            "`".FIELD_ROOSTER_CREATE_TIME."` timestamp NOT NULL default CURRENT_TIMESTAMP,".
            "`".FIELD_ROOSTER_AANMAAK_PERSOON."` varchar(".LEN_ROOSTER_AANMAAK_PERSOON.") collate latin1_general_cs NOT NULL,".
            "PRIMARY KEY  (`".FIELD_ROOSTER_ID."`),".
            "KEY `idx_".FIELD_ROOSTER_STATUS_ID."` (`".FIELD_ROOSTER_STATUS_ID."`)".
            ") ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs";            
        if ( !$this->dbquery($q)) {
            $this->checkDbErrors($q);
            trigger_error(__FILE__. ' '.__LINE__ . ' Found errors '. __FUNC__ . '<br/>');
            return FALSE;
        }
    }
}
?>
