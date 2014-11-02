<?php
/**
 * Description of db_messageboard_status
 *
 * @author GHoogendoorn
 * @version 0.1
 */

include_once 'db_type.php';

class DbMessageboardStatus extends DbType {

    
    public function DbMessageboardStatus(){
        $init = !($this->dbTableExists(TBL_MESSAGESTATUS));

        parent::__construct( TBL_MESSAGESTATUS,
                        FIELD_MSG_STATUS_ID,
                        FIELD_MSG_STATUS_NAME,LEN_MSG_STATUS_NAME,
                        FIELD_MSG_STATUS_DESC, LEN_MSG_STATUS_DESC);
        
        if ($init === TRUE){
            $this->initDbTable();
        }
    }

    /**
     * The firsth status is always new,
     * but the Id does change.
     * Hence this function...
     * @return bool FALSE | int Id from the new status
     */
    public function getNewStatusId(){
        $query = "SELECT `". FIELD_MSG_STATUS_ID ."` FROM `". TBL_MESSAGESTATUS .
                    "` WHERE `". FIELD_MSG_STATUS_NAME ."`='". MSG_STATUS_NEW ."'";
        $result = $this->dbquery($query);
        if ( !$this->checkDbErrors($query)){
            $id = $this->dbFetchArray();

            /* Return only id */
            return $id[FIELD_MSG_STATUS_ID];
        }
        return FALSE;
    }

    /**
     *
     * Insert the default entry:<br />
     *  Values should be defined in the constants language file
     *
     *      TXT_MSG_TYPE_DESCRIPTION_MODULE
     *
     * @return bool TRUE if query succeeded
     */
    private  function initDbTable(){
        $query = "INSERT INTO `". $this->table_name .
                 "`(`". $this->name_field ."`,`$this->desc_field`)".
                 " VALUES ".
                 "('".MSG_STATUS_NEW."','TXT_MSG_STATUS_NEW'),".
                 "('".MSG_STATUS_INPROGRESS."','TXT_MSG_STATUS_PROGRESS'),".
                 "('".MSG_STATUS_CLOSED."','TXT_MSG_STATUS_CLOSED')";


        $this->dbquery($query);
        if($this->checkDbErrors($query)){
            return FALSE;
        }
        return TRUE;
    }
}
?>
