<?php
/**
 * Description of db_messageboard_change_history
 *
 * @author GHoogendoorn
 * @version 0.2
 *
 * Version information:
 * 0.1      GHoogendoorn initial version
 * 0.2
 */
class DbMessageChangeHistory extends Database {

    private $change_id;
    private $msg_id;
    private $user_id;
    private $change_time;
    private $change_desc;

    public function DbMessageChangeHistory(){
        parent::__construct();

        /* Check whether the database already is created */
        if( !$this->dbTableExists(TBL_MESSAGE_CHANGE_HISTORY)){
            $this->createTable();
        }
    }
    
    public function save($msg_id,$user_id,$desc){
        if (    $this->checkId($msg_id, FIELD_MSGBRD_ID)   &&
                $this->checkId($user_id, FIELD_USER_ID)    &&
                $this->checkDesc($desc, FIELD_MSG_CHANGE_DESC)){
            //Save
        }
    }

    public function setUserId($userid){
        
    }

    private function createTable(){
    /* Table Message change history */
        $query = "CREATE TABLE `".DB_NAME."`.`".TBL_MESSAGE_CHANGE_HISTORY."` (".
            "`".FIELD_MSG_CHANGE_ID."` BIGINT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,".
            "`".FIELD_MSGBRD_ID."` BIGINT( 10 ) NOT NULL ,".
            "`".FIELD_USER_ID."` BIGINT( 10 ) NOT NULL ,".
            "`".FIELD_MSG_CHANGE_TIME."` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,".
            "`".FIELD_MSG_CHANGE_DESC."` VARCHAR( 1024 ) NOT NULL ,".
            "INDEX `idx_".FIELD_MSGBRD_ID."` ( `".FIELD_MSGBRD_ID."` )".
            ") ENGINE = MYISAM ";

        if ( !$this->dbquery($query)) {
            $this->checkDbErrors($query);
            return FALSE;
        }
    }

}
?>
