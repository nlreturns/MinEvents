<?php
/**
 * Description of db_messageboard_status
 *
 * @author GHoogendoorn
 * @version 0.1
 */
namespace minevents\app\classes\db;

class DbRoosterStatus extends DbType {

    
    public function DbRoosterStatus(){
      

        $init = !($this->dbTableExists(TBL_ROOSTERSTATUS));

        parent::__construct( TBL_ROOSTERSTATUS,
                        FIELD_ROOSTER_STATUS_ID,
                        FIELD_ROOSTER_STATUS_NAME,LEN_ROOSTER_STATUS_NAME,
                        FIELD_ROOSTER_STATUS_DESC, LEN_ROOSTER_STATUS_DESC);
        
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
        $query = "SELECT `". FIELD_ROOSTER_STATUS_ID ."` FROM `". TBL_ROOSTERSTATUS .
                    "` WHERE `". FIELD_ROOSTER_STATUS_NAME ."`='".ROOSTER_STATUS_NEW ."'";
        $result = $this->dbquery($query);
        if ( !$this->checkDbErrors($query)){
            $id = $this->dbFetchArray();

            /* Return only id */
            return $id[FIELD_ROOSTER_STATUS_ID];
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
                 "('".ROOSTER_STATUS_NEW."','".TXT_ROOSTER_STATUS_NEW."'),".
                 "('".ROOSTER_STATUS_INPROGRESS."','".TXT_ROOSTER_STATUS_PROGRESS."'),".
                 "('".ROOSTER_STATUS_CLOSED."','".TXT_ROOSTER_STATUS_CLOSED."')";

        $this->dbquery($query);
        if($this->checkDbErrors($query)){
            return FALSE;
        }
        return TRUE;
    }
}
?>
