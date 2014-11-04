<?php
namespace minevents\app\classes\db;

/**
 * Description of db_messageboard_module
 *
 * @author GHoogendoonr
 * @version 0.1
 */

class DbModule extends Database {

    public function DbModule(){
        parent::__construct();

        /* Check whether the database already is created */
        if( !$this->dbTableExists(TBL_MODULE)){
            $this->createTable();
        }
    }

    private function createTable(){

        /* Table module */
        if( !$this->dbTableExists(TBL_MODULE)){
            $query = "CREATE TABLE `".DB_NAME."`.`".TBL_MODULE."` (".
                "`".FIELD_MODULE_ID."` BIGINT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,".
                "`".FIELD_MODULE_NAME."` VARCHAR( 32 ) NOT NULL ,".
                "`".FIELD_MODULE_DESC."` VARCHAR( 1024 ) NOT NULL ,".
                "INDEX ( `".FIELD_MODULE_NAME."` )".
                ") ENGINE = MYISAM ";

            if ( !$this->dbquery($query)) {
                $this->checkDbErrors($query);
                return FALSE;
            }
        }
    }
}
?>
