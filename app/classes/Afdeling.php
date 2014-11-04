<?php
namespace minevents\app\classes;
/**
 * DbDomein connects the application to the database using Database.php
 */
class Afdeling {
    /**
     * Description of afdeling.
     * @var type varchar
     */
    public $afdeling_desc;
    /**
     * Id of afdeling.
     * @var type int
     */
    public $afdeling_id;
    /**
     * Title of afdeling.
     * @var type varchar
     */
    public $afdeling_title;
    /**
     * Returns an array with errors.
     * @var type array
     * @return error array
     */
    public $mysqli;
    private $db;
    /**
     * Calls Item's constructor. 
     */
    public function __construct() {
        // insert name of the table, id field, title field and description field
        $this->db = new Item('afdeling', 'afdeling_id', 'afdeling_naam', 'afdeling_beschrijving');
    }
    /**
     * Adds afdeling using the inserted parameters and DbItem's functions.
     * @param type $afdeling_title
     * @param type $afdeling_desc
     * @return boolean
     */
    public function add($afdeling_title, $afdeling_desc){
        // if title and desc are empty:
        if(empty($afdeling_title) and empty($afdeling_desc)){
            // return error
            echo ERROR_MISSING_BOTH;
            return FALSE;
        // if title is empty
        }elseif(empty($afdeling_title)){
            // return error
            echo ERROR_MISSING_TITLE;
            return FALSE;
        // if description is empty
        }elseif(empty($afdeling_desc)){
             // return error
            ERROR_MISSING_DESC;
            return FALSE;
        // if both vars are filled
        }elseif(!empty($afdeling_title) or !empty($afdeling_desc)){
            // execute DbItem's addItem using inserted parameters
            return $this->db->addItem($afdeling_title, $afdeling_desc);
        }
        
    }
    /**
     * Edits afdeling using the inserted parameters and DbItem's functions.
     * @param type $afdeling_id
     * @param type $afdeling_title
     * @param type $afdeling_desc
     * @return type bool
     */
    public function edit($afdeling_id, $afdeling_title, $afdeling_desc){
        return $this->db->editItem($afdeling_id, $afdeling_title, $afdeling_desc);
    }
    /**
     * Gets afdeling by id from database using DbItem's getItemById. 
     * @param type $afdeling_id
     * @return type array
     */
    public function getAfdelingById($afdeling_id){
        return $this->db->getItemById($afdeling_id);
        
    }
    /**
     * Gets entire list from database using DbItem's getItemList.
     * @return type array
     */
    public function getList(){
        return $this->db->getList();
    }
    public function setTitel($value) {
        $this->afdeling_title = $value;
    }
    public function setBeschrijving($value) {
        $this->afdeling_desc = $value;
    }
    public function create() {
        $this->db->createAfdeling($this->afdeling_title, $this->afdeling_desc);
    }
}
?>