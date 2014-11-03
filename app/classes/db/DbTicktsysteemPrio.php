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

namespace minevents\app\classes\db;

class DbTicketsysteemPrio extends DbType  {

    
    public function DbTicketsysteemPrio(){
        parent::__construct();

        $init = !($this->dbTableExists(TBL_TICKETPRIO));

        parent::__construct( TBL_TICKETPRIO,
                        FIELD_TICKET_PRIO_ID,
                        FIELD_TICKET_PRIO_NAME,LEN_TICKET_PRIO_NAME,
                        FIELD_TICKET_PRIO_DESC, LEN_TICKET_PRIO_DESC);
        
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
    public function getNewPrioId(){
        $query = "SELECT `". FIELD_TICKET_PRIO_ID ."` FROM `". TBL_TICKETPRIO .
                    "` WHERE `". FIELD_TICKET_PRIO_NAME ."`='". TICKET_PRIO_NEW ."'";
        $result = $this->dbquery($query);
        if ( !$this->checkDbErrors($query)){
            $id = $this->dbFetchArray();

            
            return $id[FIELD_TICKET_PRIO_ID];
        }
        return FALSE;
    }
    /**
     *
     * Insert the default entry:<br />
     *  Values should be defined in the constants language file
     *
     *      TXT_TICKET_PRIO_DESCRIPTION_MODULE
     *
     * @return bool TRUE if query succeeded   ('".$this->dbInString($prio_id)."','".
     */
    private  function initDbTable(){
        $query = "INSERT INTO `". $this->table_name .
                 "`(`". $this->name_field ."`,`$this->desc_field`)".
                 " VALUES ".
                    "('".TICKET_PRIO_VEILIGHEID."',$this->dbInString('Veiligheid')),".
                 "('".TICKET_PRIO_COMMERCIEEL."',$this->dbInString('Commercieel')),".
                 "('".TICKET_PRIO_ONDERHOUD."',$this->dbInString('Onderhoud'))";


        $this->dbquery($query);
        if($this->checkDbErrors($query)){
            return FALSE;
        }
        return TRUE;
    }
}
?>
