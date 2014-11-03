<?php
include_once FILE_DATABASE;
require_once DIR_DEFINES. 'db_constants.php';
/**
 * Description of ticketsysteem_proriteit
 * 
 *
 * @author JDuysserinck
 * @version 0.2
 *
 * Version History :
 * 0.1  Initial version.
 * 0.2  Added gets for prioriteit
 */
class Prioriteit extends Database {
    protected $ticket_prio_id;
    protected $ticket_prio_label;
    protected $ticket_prio_beschrijving;
    protected $prio_name_len;
    
     // get the priority description using priority ID
 public function getPrioNameById($ticket_prio_id){

        if ($this->checkId($ticket_prio_id, $this->ticket_prio_id)){

            $query = "SELECT `".$this->ticket_prio_beschrijving."`".
                    "FROM `".$this->ticket_prio."`".
                    "WHERE `".$this->ticket_prio_id ."` = '". $ticket_prio_id . "'";
            $this->dbquery($query);
            if ( $this->checkDbErrors($query) ){

                return FALSE;
            }
            $status_array = $this->dbFetchArray();
            if ( $this->checkDbErrors($query) ){

                return FALSE;
            }

        } else {
            return FALSE;
        }
        return ($status_array[$this->ticket_prio_beschrijving]);
    }
     // get the priority ID using priority description
      public function getPrioIdByName($ticket_prio_beschrijving){
        
        if ($this->checkText($ticket_prio_beschrijving, $this->prio_name_len) ){

            $query = "SELECT `".$this->ticket_prio_id."`".
                    "FROM `".$this->ticket_prio."`".
                    "WHERE `".$this->ticket_prio_beschrijving ."` = '". $this->dbInString($ticket_prio_beschrijving) . "'";

            $this->dbquery($query);
            if ( $this->checkDbErrors($query) ){

                return FALSE;
            }
            
            $status_array = $this->dbFetchArray();
            if ( $this->checkDbErrors($query) ){

                return FALSE;
            }
        } else {
            return FALSE;
        }
        
        return $status_array[$this->ticket_prio_id];
    }
}
?>
