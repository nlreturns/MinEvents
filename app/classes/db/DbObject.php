<?php
namespace minevents\app\classes\db;
/**
 * Description of db_object
 * 
 *
 * @author Donny
 * @version 0.9
 *
 * Version History :
 */

class DbObject extends Database {
    
    private $object_id;
    private $object_naam;
    private $afdelingid;
    private $db;
    
    public function __construct() {
    	$this->db = new Database;
    }

    public function createObject() {
        $sql = "INSERT INTO object (object_naam, afdeling_id) VALUES ('".$this->object_naam."', '".$this->afdelingid."')";
        $this->db->dbquery($sql);
    }
    public function setObjectNaam($object) {
        $this->object_naam = $object;
    }

    public function setAfdelingId($afdelingid) {
        $this->afdelingid = $afdelingid;
    }
    public function getObjectById($object_id){
        // Query selects the item using inserted parameter.
        $query = "SELECT * FROM `object` WHERE 
            `object_id` =". mysql_real_escape_string($object_id) ."";
        // fetches the array using Database's fetchDbArray function.
        // If it's null,
        if (!$this->db->dbquery($query)) {
            return false;
        }
        if(!($result = $this->db->dbFetchAll())){
            // set error.
            echo TXT_NO_DATA;
            return FALSE;
        }
        return $result;
            
    }
    public function getList(){
        // Query selects the item using class vars.
        $query = "SELECT * FROM  `object` ORDER BY  `object`.`object_id` ASC";
        // fetches the array using Database's fetchDbArray function.
        // If it's null,
        if (!$this->db->dbquery($query)) {
            return false;
        }
        if(!($result = $this->db->dbFetchAll())){
            // set error.
            echo TXT_NO_DATA;
            return FALSE;
        }
        return $result;
            
    }
}
?>