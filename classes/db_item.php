<?php
require_once FILE_DATABASE;
define("FIELD_ID_LENGTH", 10);
define("FIELD_TITLE_LENGTH", 50);
/**
 * Class Item is used to connect classes that have an id, title, and desc to the database.
 */
class DbItem extends Database{
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
     * Returns an array with errors.
     * @var type array
     * @return error array
     */
    public $table;
    /**
     * Id field of the database table.
     * @var type int
     */
    public $tbl_id;
    /**
     * Title field of the database table.
     * @var type 
     */
    public $tbl_title;
    /**
     * Description field of the database table.
     */
    public $tbl_desc;
            
    /**
     * Calls Database's constructor. 
     * Sets class vars. If table with name $table doesn't exist, make it! 
     */
    public function __construct($table, $tbl_id, $tbl_title, $tbl_desc) {
        parent::__construct();
        
        $this->table = $table;
        $this->tbl_id = $tbl_id;
        $this->tbl_title = $tbl_title;
        $this->tbl_desc = $tbl_desc;
        // check if the table exists.
        /*if(!$this->checkIfTableExist()){
            // if it doesn't: create the table using the previously set class vars
            return $this->createTbl($this->table, $this->tbl_id, $this->tbl_title, $this->tbl_desc);
        }else{
            // if it does: return true :D!
            return TRUE;
        }*/
    }
    /**
     * Adds an item.
     * @param type $item_title
     * @param type $item_desc
     * @return boolean
     */
    public function addItem($item_title, $item_desc){
        // query insrts the title and desc into the table.
        $query = "INSERT INTO  `" . DB_NAME . "`.`". $this->table . "` (
                    `" . $this->tbl_title . "`,
                    `" . $this->tbl_desc . "`)
                  VALUES ('" . mysql_real_escape_string($item_title) . "',
                          '" . mysql_real_escape_string($item_desc) . "'
                  )";
        // if the query returns false
        if (!$this->dbquery($query)){
            // set the error.
            echo mysql_error();
            return FALSE;
            
        }else{
            // if it executes, set the class vars to the previously inserted parameters.
            $this->item_title = $item_title;
            $this->item_desc = $item_desc;
            return TRUE;
            
        }
        
    }
    /**
     * Checks if the table exists. 
     * @return boolean
     */
    public function checkIfTableExist(){
        // query shows the tables with the inserted title
        $query = "SHOW TABLES LIKE " . $this->table;
        // if the query returns false
        if (!$this->dbquery($query)){
            // set the error.
            //echo mysql_error();
            return FALSE;

        }else{
            // if it executed, return true.
            return TRUE;
        }
        
    }
    /**
     * Create the table using class vars.
     * @return boolean
     */
    public function createTbl(){
        /**
         * Query creates the table usig class vars. 
         */
        $query = "CREATE TABLE `".DB_NAME."`.`".$this->table."` (".
                "`".$this->tbl_id."` INT(" . FIELD_ID_LENGTH . ") NOT NULL AUTO_INCREMENT PRIMARY KEY ,".
                "`".$this->tbl_title."` VARCHAR(" . FIELD_TITLE_LENGTH . ") NOT NULL ,".
                "`".$this->tbl_desc."` LONGTEXT NOT NULL".
                ") ENGINE = MYISAM ";
        // if the query returns false
        if (!$this->dbquery($query)){
            // set the error.
            echo mysql_error();
            return FALSE;
            
        }else{
            // if it executes, return true
            return TRUE;
            
        }
    }
    /**
     * Edit an item.
     * @param type $item_id
     * @param type $item_title
     * @param type $item_desc
     * @return boolean
     */
    public function editItem($item_id, $item_title, $item_desc){
        // Query updates the item using inserted parameters. 
        $query = "UPDATE `" . $this->table . "` 
            SET `" . $this->tbl_title . "` = '" . mysql_real_escape_string($item_title) . "', 
                `" . $this->tbl_desc . "` = '" . mysql_real_escape_string($item_desc) . "' WHERE 
                `" . $this->table . "`.`" . $this->tbl_id . "` =" . mysql_real_escape_string($item_id) . ";";
        // if the query returns false
        if (!$this->dbquery($query)){
            // set the error.
            echo mysql_error();
            return FALSE;

        }else{
            // if it executes, return true
            $this->item_title = $item_title;
            $this->item_desc = $item_desc;
            return TRUE;
        }
    }
    /**
     * Gets an item by the inserted id.
     * @param type $item_id
     * @return boolean
     */
    public function getItemById($item_id){
        // Query selects the item using inserted parameter.
        $query = "SELECT * FROM `" . $this->table . "` WHERE 
            `" . $this->tbl_id . "` =". mysql_real_escape_string($item_id) ."";
        // fetches the array using Database's fetchDbArray function.
        // If it's null,
        if (!$this->dbquery($query)) {
            return false;
        }
        if(!($result = $this->dbFetchAll())){
            // set error.
            echo TXT_NO_DATA;
            return FALSE;
        }
        return $result;
            
    }
    /**
     * Gets the entire database array.
     * @return boolean
     */
    public function getItemList(){
        // Query selects the item using class vars.
        $query = "SELECT * FROM  `". $this->table . "` ORDER BY  `". $this->table . "`.`" . $this->tbl_title . "` ASC";
        // fetches the array using Database's fetchDbArray function.
        // If it's null,
        if (!$this->dbquery($query)) {
            return false;
        }
        if(!($result = $this->dbFetchAll())){
            // set error.
            echo TXT_NO_DATA;
            return FALSE;
        }
        return $result;
            
    }
    public function deleteItem($item_title, $item_desc, $item_id) {

        $query = "DELETE FROM afdeling WHERE afdeling . item_title , item_desc = '" . mysql_real_escape_string($item_title, $item_desc, $item_id) . "'  LIMIT 1 ";

        if (!$this->dbquery($query)) {
            return false;
        }
    }
}


?>
