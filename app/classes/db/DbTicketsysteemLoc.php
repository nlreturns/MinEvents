<?php
namespace minevents\app\classes\db;

class DbTicketsysteemLoc extends DbType  {

    
    public function DbTicketsysteemLoc(){
        parent::__construct();

        $init = !($this->dbTableExists(TBL_TICKETLOC));

        parent::__construct( TBL_TICKETLOC,
                        FIELD_TICKET_LOC_ID,
                        FIELD_TICKET_LOC_NAME,LEN_TICKET_LOC_NAME,
                        FIELD_TICKET_LOC_DESC, LEN_TICKET_LOC_DESC);
        
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
    public function getNewLocId(){
        $query = "SELECT `". FIELD_TICKET_LOC_ID ."` FROM `". TBL_TICKETLOC .
                    "` WHERE `". FIELD_TICKET_LOC_NAME ."`='". TICKET_LOC_NEW ."'";
        $result = $this->dbquery($query);
        if ( !$this->checkDbErrors($query)){
            $id = $this->dbFetchArray();

            /* Return only id */
            return $id[FIELD_TICKET_LOC_ID];
        }
        return FALSE;
    }

    /**
     *
     * Insert the default entry:<br />
     *  Values should be defined in the constants language file
     *
     *      TXT_TICKET_LOC_DESCRIPTION_MODULE
     *
     * @return bool TRUE if query succeeded 
     */
    private  function initDbTable(){
        $query = "INSERT INTO `". $this->table_name .
                 "`(`". $this->name_field ."`,`$this->desc_field`)".
                 " VALUES ".
                 "('".TICKET_LOC_RECEPTIE."',$this->dbInString('Receptie')),".
                 "('".TICKET_LOC_BRASSERIE_BAR."',$this->dbInString('Brasserie/Bar')),".
                 "('".TICKET_LOC_BOWLING."',$this->dbInString('Bowling')),".
                 "('".TICKET_LOC_TOILETTEN."',$this->dbInString('Toiletten')),".
                 "('".TICKET_LOC_KEUKEN."',$this->dbInString('Keuken')),".
                 "('".TICKET_LOC_FEESTZAAL."',$this->dbInString('Feestzaal')),".
                "('".TICKET_LOC_SPEELZAAL_COUNTER."',$this->dbInString('Speelzaal/Counter')),".
                 "('".TICKET_LOC_TERRAS_BUITEN."',$this->dbInString('Terras/Buiten')),".
                "('".TICKET_LOC_LASERGAME."',$this->dbInString('Lasergame')),".
                 "('".TICKET_LOC_KANTOOR."',$this->dbInString('Kantoor')),".
                 "('".TICKET_LOC_OVERIG."',$this->dbInString('Overig'))";


        $this->dbquery($query);
        if($this->checkDbErrors($query)){
            return FALSE;
        }
        return TRUE;
    }
}
?>
