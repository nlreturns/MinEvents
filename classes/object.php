<?php
include_once 'db_object.php';
include_once 'afdeling.php';
/**
 * 
 */
class Object {

	private $object_naam;
	private $afdelingid;
        private $afdeling;
	private $db;

	public function __construct() {
            $this->db = new DbObject();
            $this->afdeling = new Afdeling();
	}
        public function setObjectNaam($value) {
            $this->object_naam = $value;
        }
        public function setAfdelingId($value) {
            $this->afdelingid = $value;
        }
        public function create() {
            $this->db->setObjectNaam($this->object_naam);
            $this->db->setAfdelingId($this->afdelingid);
            $this->db->createObject();
        }
        public function getList(){
            return $this->db->getList();
        }
        public function getObjectById($object_id){
            return $this->db->getObjectById($object_id);
        }
        public function getAfdeling($afdelingid){
            return $this->afdeling->getAfdelingById($afdelingid);
        }
}
?>