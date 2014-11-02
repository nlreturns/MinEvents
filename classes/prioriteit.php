<?php
include_once 'Item.php';
/**
 * DbDomein connects the application to the database using Database.php
 */
class Prioriteit {
    /**
     * Description of prioriteit.
     * @var type varchar
     */
    public $prioriteit_desc;
    /**
     * Id of prioriteit.
     * @var type int
     */
    public $prioriteit_id;
    /**
     * Title of prioriteit.
     * @var type varchar
     */
    public $prioriteit_title;
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
        $this->db = new Item('ticket_prio', 'ticket_prio_id', 'ticket_prio_label', 'ticket_prio_beschrijving');
    }
    /**
     * Adds prioriteit using the inserted parameters and DbItem's functions.
     * @param type $prioriteit_title
     * @param type $prioriteit_desc
     * @return boolean
     */
    public function add($prioriteit_title, $prioriteit_desc){
        // if title and desc are empty:
        if(empty($prioriteit_title) and empty($prioriteit_desc)){
            // return error
            echo ERROR_MISSING_BOTH;
            return FALSE;
        // if title is empty
        }elseif(empty($prioriteit_title)){
            // return error
            echo ERROR_MISSING_TITLE;
            return FALSE;
        // if description is empty
        }elseif(empty($prioriteit_desc)){
             // return error
            ERROR_MISSING_DESC;
            return FALSE;
        // if both vars are filled
        }elseif(!empty($prioriteit_title) or !empty($prioriteit_desc)){
            // execute DbItem's addItem using inserted parameters
            return $this->db->addItem($prioriteit_title, $prioriteit_desc);
        }
        
    }
    /**
     * Edits prioriteit using the inserted parameters and DbItem's functions.
     * @param type $prioriteit_id
     * @param type $prioriteit_title
     * @param type $prioriteit_desc
     * @return type bool
     */
    public function edit($prioriteit_id, $prioriteit_title, $prioriteit_desc){
        return $this->db->editItem($prioriteit_id, $prioriteit_title, $prioriteit_desc);
    }
    /**
     * Gets prioriteit by id from database using DbItem's getItemById. 
     * @param type $prioriteit_id
     * @return type array
     */
    public function getPrioriteitById($prioriteit_id){
        return $this->db->getItemById($prioriteit_id);
        
    }
    /**
     * Gets entire list from database using DbItem's getItemList.
     * @return type array
     */
    public function getList(){
        return $this->db->getList();
    }
    public function setTitel($value) {
        $this->prioriteit_title = $value;
    }
    public function setBeschrijving($value) {
        $this->prioriteit_desc = $value;
    }
    public function create() {
        $this->db->createPrioriteit($this->prioriteit_title, $this->prioriteit_desc);
    }
}
?>