<?php
namespace minevents\app\classes\db;
/**
 * Description of db_marketing_telefoontype
 *
 * @author Martijn Wink
 * @version 0.1
 */


class DbMarketingTelefoonType extends DbType{

    
    public function DbMarketing_telefoontype(){
        parent::__construct();

        $init = !($this->dbTableExists(TBL_MARKETING_TELEFOONTYPE));

        parent::DbType( TBL_MARKETING_TELEFOONTYPE,
                        FIELD_MARKETING_KLANTID,
                        FIELD_MARKETING_NAAM,LEN_MARKETING_NAAM);                        
        
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
        $query = "SELECT `". FIELD_MARKETING_KLANT_ID ."` FROM `". TBL_MARKETING_TELEFOONTYPE .
                    "` WHERE `". FIELD_MARKETING_NAAM ."'";
        $result = $this->dbquery($query);
        if ( !$this->checkDbErrors($query)){
            $id = $this->dbFetchArray();

            /* Return only id */
            return $id[FIELD_MARKETING_KLANT_ID];
        }
        return FALSE;
    }

    /**
     *
     * Insert the default entry:<br />
     *  Values should be defined in the constants language file
     *
     *      TXT_MARKETING_TYPE_DESCRIPTION_MODULE
     *
     * @return bool TRUE if query succeeded
     */
    private  function initDbTable(){
        $query = "INSERT INTO `". $this->table_name .
                 "`(`". $this->name_field ."`,`$this->desc_field`)".
                 " VALUES ".
                 "('".MARKETING_STATUS_NEW."','TXT_MARKETING_STATUS_NEW'),".
                 "('".MARKETING_STATUS_INPROGRESS."','TXT_MARKETING_STATUS_PROGRESS'),".
                 "('".MARKETING_STATUS_CLOSED."','TXT_MARKETING_STATUS_CLOSED')";


        $this->dbquery($query);
        if($this->checkDbErrors($query)){
            return FALSE;
        }
        return TRUE;
    }
}
?>
