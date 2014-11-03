<?php
/**
 * Description of db_messageboard_type
 *
 * @author GHoogendoorn
 * @version 0.1
 */
include_once FILE_DB_TYPE;

class DbMessageboardType extends DbType {


    public function DbMessageboardType(){


        $init = !($this->dbTableExists(TBL_MESSAGETYPE));

        parent::__construct( TBL_MESSAGETYPE,
                        FIELD_MSG_TYPE_ID,
                        FIELD_MSG_TYPE_NAME, LEN_MSG_TYPE_NAME,
                        FIELD_MSG_TYPE_DESC, LEN_MSG_TYPE_DESC);

        if ($init === TRUE){
            $this->initDbTable();
        }
        /* Check whether the database already is created */
        

            /* Initiele message types needed by the system */
            // MSG_TYPE_MODULE
            // MSG_TYPE_PERSON
        
    }

    /**
     *
     * Insert the default entry:<br />
     *  Values should be defined in the constants language file
     *      TXT_MSG_TYPE_DESCRIPTION_PERSON
     *      TXT_MSG_TYPE_DESCRIPTION_MODULE
     * 
     * @return bool TRUE if query succeeded
     */
    private  function initDbTable(){
        $query = "INSERT INTO `". $this->table_name .
                 "`(`". $this->name_field ."`,`$this->desc_field`)".
                 " VALUES ".
                 "('".MSG_TYPE_PERSON."','TXT_MSG_TYPE_DESCRIPTION_PERSON'),".
                 "('".MSG_TYPE_MODULE."','TXT_MSG_TYPE_DESCRIPTION_MODULE')";


        $this->dbquery($query);
        if($this->checkDbErrors($query)){
            return FALSE;
        }
        return TRUE;
    }
}
?>
