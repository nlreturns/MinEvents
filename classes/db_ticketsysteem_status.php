<?php
/**
 * Description of db_ticketsysteem_loc
 *
 * @author JDuysserinck
 * @version 0.2
 * Version History :
 * 0.1  Initial version.
 * 0.2 Added save
 */

include_once 'db_type.php';

class DbTicketsysteemStatus extends DbType  {

    
    public function DbTicketsysteemStatus(){
        parent::__construct();

        $init = !($this->dbTableExists(TBL_TICKETSTATUS));

        parent::DbType( TBL_TICKETSTATUS,
                        FIELD_TICKET_STATUS_ID,
                        FIELD_TICKET_STATUS_NAME,LEN_TICKET_STATUS_NAME,
                        FIELD_TICKET_STATUS_DESC, LEN_TICKET_STATUS_DESC);
        
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
        $query = "SELECT `". FIELD_TICKET_STATUS_ID ."` FROM `". TBL_TICKETSTATUS .
                    "` WHERE `". FIELD_TICKET_STATUS_NAME ."`='". TICKET_STATUS_NEW ."'";
        $result = $this->dbquery($query);
        if ( !$this->checkDbErrors($query)){
            $id = $this->dbFetchArray();

            /* Return only id */
            return $id[FIELD_TICKET_STATUS_ID];
        }
        return FALSE;
    }

    /**
     *
     * Insert the default entry:<br />
     *  Values should be defined in the constants language file
     *
     *      TXT_TICKET_STATUS_DESCRIPTION_MODULE
     *
     * @return bool TRUE if query succeeded
     */
    private  function initDbTable(){
        $query = "INSERT INTO `". $this->table_name .
                 "`(`". $this->name_field ."`,`$this->desc_field`)".
                 " VALUES ".
                 "('".TICKET_STATUS_AANGEMELD."',$this->dbInString('Aangemeld')),".
                 "('".TICKET_STATUS_INUITVOERING."',$this->dbInString('In_Uitvoering')),".
                 "('".TICKET_STATUS_GESLOTEN."',$this->dbInString('Gesloten'))";


        $this->dbquery($query);
        if($this->checkDbErrors($query)){
            return FALSE;
        }
        return TRUE;
    }
}
?>
