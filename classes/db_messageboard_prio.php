<?php
/**
 * Description of db_messageboard_prio
 * Currently not used
 *
 * @author GHoogendoorn
 * @version 0.2
 *
 * Version History:
 * 0.1  GHoogendoorn    Initial version
 * 0.2  GHoogendoorn    Several modifications
 */
include_once FILE_DATABASE;

class DbMessageboardPrio extends Database {

    public function DbMessageboardPrio(){
        parent::__construct();

        /* Check whether the database already is created */
        if( !$this->dbTableExists(TBL_MESSAGE_PRIO)){
            $this->createTable();
        }
    }

    private function createTable(){

       /* Table Message prio */
        $query = "CREATE TABLE `".DB_NAME."`.`".TBL_MESSAGE_PRIO."` (".
            "`".FIELD_MSG_PRIO_LEVEL."` VARCHAR( 16 ) NOT NULL ,".
            "`".FIELD_MSG_PRIO_DESC."` VARCHAR( 1024 ) NOT NULL ,".
            "PRIMARY KEY ( `".FIELD_MSG_PRIO_LEVEL."` )".
            ") ENGINE = MYISAM ";

        if ( !$this->dbquery($query)) {
            $this->checkDbErrors($query);
            return FALSE;
        }
    }
}
?>
