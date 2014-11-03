<?php
include_once FILE_DB_ITEM;
/**
 * DbDomein connects the application to the database using Database.php
 */
class Item{
    /** 
     * Calls DbItem class
     * @var type DbItem()
     */
    public $db_item;
    /**
     * Description of item.
     * @var type varchar
     */
    public $item_desc;
    /**
     * Id of item.
     * @var type int
     */
    public $item_id;
    /**
     * Title of item.
     * @var type varchar
     */
    public $item_title;
    /**
     * Calls Item's constructor. 
     */
    public function __construct($table, $id, $title, $desc) {
        $this->db_item = new DbItem($table, $id, $title, $desc);
    }
    /**
     * Adds item using the inserted parameters and DbItem's functions.
     * @param type $item_title
     * @param type $item_desc
     * @return boolean
     */
    public function addItem($item_title, $item_desc){
        // if title and desc are empty:
        if(empty($item_title) and empty($item_desc)){
            // return error
            echo ERROR_MISSING_BOTH;
            return FALSE;
        // if title is empty
        }elseif(empty($item_title)){
            // return error
            echo ERROR_MISSING_TITLE;
            return FALSE;
        // if description is empty
        }elseif(empty($item_desc)){
             // return error
            echo ERROR_MISSING_DESC;
            return FALSE;
        // if both vars are filled
        }elseif(!empty($item_title) or !empty($item_desc)){
            // execute DbItem's addItem using inserted parameters
            return $this->db_item->addItem($item_title, $item_desc);
        }
        
    }
    /**
     * Edits item using the inserted parameters and DbItem's functions.
     * @param type $item_id
     * @param type $item_title
     * @param type $item_desc
     * @return type bool
     */
    public function edit($item_id, $item_title, $item_desc){
        return $this->db_item->editItem($item_id, $item_title, $item_desc);
    }
    /**
     * Gets item by id from database using DbItem's getItemById. 
     * @param type $item_id
     * @return type array
     */
    public function getItemById($item_id){
        return $this->db_item->getItemById($item_id);
        
    }
    public function deleteItem($item_title, $item_desc, $item_id) {
        $this->deleteAfdeling($this->$item_title, $item_desc, $item_id);
    }
    /**
     * Gets entire list from database using DbItem's getItemList.
     * @return type array
     */
    public function getList(){
        return $this->db_item->getItemList();
    }
}
?>