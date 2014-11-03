<?php
include_once FILE_DATABASE;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Location extends Database {
    protected $loc_id;
    protected $loc_label;
    protected $loc_beschrijving;
    
 public function getLocNameById($id){

        if ($this->checkId($id, $this->loc_id)){

            $query = "SELECT `".$this->loc_beschrijving."`".
                    "FROM `".$this->ticket_loc."`".
                    "WHERE `".$this->loc_id ."` = '". $loc_id . "'";
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
        return ($status_array[$this->loc_beschrijving]);
    }
    
      public function getLocIdByName($loc_beschrijving){
        
        if ($this->checkText($name, $this->name_len) ){

            $query = "SELECT `".$this->loc_id."`".
                    "FROM `".$this->ticket_loc."`".
                    "WHERE `".$this->loc_beschrijving ."` = '". $this->dbInString($loc_beschrijving) . "'";

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
