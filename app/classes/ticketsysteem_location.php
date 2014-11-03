<?php
include_once FILE_DATABASE;
require_once DIR_DEFINES. 'db_constants.php';
/**
 * Description of ticketsysteem_location
 * 
 *
 * @author JDuysserinck
 * @version 0.2
 *
 * Version History :
 * 0.1  Initial version.
 * 0.2  Added gets for location
 */
class Location extends database{
    protected $loc_id;
    protected $ticket_loc_label;
    protected $loc_name;
    protected $loc_name_len;
    
    // get the location description using location ID
 public function getLocNameById($loc_id){

        if ($this->checkId($loc_id, $this->loc_id)){

            $query = "SELECT `".$this->FIELD_TICKET_LOC_NAME."`".
                    "FROM `".$this->TBL_TICKETLOC."`".
                    "WHERE `".$this->FIELD_TICKET_LOC_ID ."` = '". $loc_id . "'";
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
        return ($status_array[$this->loc_name]);
    }
    
     // get the location ID using location description
      public function getLocIdByName($loc_name){
        
        if ($this->checkText($loc_name, $this->loc_name)) {

            $query = "SELECT `".$this->FIELD_TICKET_LOC_ID."`".
                    "FROM `".$this->TBL_TICKETLOC."`".
                    "WHERE `".$this->FIELD_TICKET_LOC_NAME ."` = '". $this->dbInString($loc_name) . "'";

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
        
        return $status_array[$this->loc_id];
    }
}
?>
