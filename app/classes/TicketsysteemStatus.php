<?php
namespace minevents\app\classes;
/**
 * Description of ticketsysteem_status
 * 
 *
 * @author JDuysserinck
 * @version 0.2
 *
 * Version History :
 * 0.1  Initial version.
 * 0.2  Added gets for status
 */
class TicketsysteemStatus extends Database {
    protected $ticket_status_id;
    protected $ticket_status_label;
    protected $ticket_status_beschrijving;
    protected $status_name_len;
    
     // get the status description using status ID
 public function getStatusNameById($ticket_status_id){

        if ($this->checkId($ticket_status_id, $this->ticket_status_id)){

            $query = "SELECT `".$this->ticket_status_beschrijving."`".
                    "FROM `".$this->ticket_status."`".
                    "WHERE `".$this->ticket_status_id ."` = '". $ticket_status_id . "'";
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
        return ($status_array[$this->ticket_status_beschrijving]);
    }
    
    // get the status ID using status description
      public function getStatusIdByName($ticket_status_beschrijving){
        
        if ($this->checkText($ticket_status_beschrijving, $this->status_name_len) ){

            $query = "SELECT `".$this->ticket_status_id."`".
                    "FROM `".$this->ticket_status."`".
                    "WHERE `".$this->ticket_status_beschrijving ."` = '". $this->dbInString($ticket_status_beschrijving) . "'";

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
        
        return $status_array[$this->ticket_status_id];
    }
}
?>
