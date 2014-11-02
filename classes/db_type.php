<?php
include_once FILE_DATABASE;

/**
 * This class facilitates the functioning of
 *  general ID | NAME | DESCRIPTION type MySQL tables.
 *
 * @author GHoogendoorn
 * @version 0.3
 *
 * Version history:
 * 0.1  GHoogendoorn    Initial version
 * 0.2  GHoogendoorn    Improvements (public classes 2 protected a.o.)
 * 0.3  GHoogendoorn    changes and additions
 */
class DbType extends Database {
    protected $id;
    protected $desc;
    protected $name;
    protected $table_name;
    protected $id_field;
    protected $name_field;
    protected $name_len;
    protected $desc_field;
    protected $desc_len;

    
    public function __construct($table = '', $id_field = '', $name_field = '', $name_len = '', $desc_field = '', $desc_len = ''){
     
        parent::__construct();

        $this->table_name = $table;
        $this->id_field = $id_field;
        $this->name_field = $name_field;
        $this->desc_field = $desc_field;
        $this->name_len = $name_len;
        $this->desc_len = $desc_len;

//        echo "<pre>";
//        var_dump($table);
//        var_dump($id_field);
//        var_dump($name_field);
//        var_dump($desc_field);
//        var_dump($name_len);
//        echo "</pre>";
        if( !$this->dbTableExists($this->table_name)){
            $this->createTable();
             
        }
    }
    
    /**
     * DbType->save()
     * @param string $name name of the DbType
     * @param <type> $desc description of the DbType
     * 
     * @return <type> 
     */
    protected function save($name, $desc){

        if ( $this->checkText($desc, $this->desc_len ) &&
             $this->checkText($name, $this->name_len ) ) {

            $query= "INSERT INTO `".$this->table_name.
                    "`(`". $this->name_field .
                    "`,`". $this->desc_field .
                    "`) VALUES ('". $this->dbInString($name)."',".
                    "'". $this->dbInString($desc)."')";

            $this->dbquery($query);
            if($this->checkDbErrors($query)){
                return FALSE;
            }

            /* Update class attributes */
            $this->setId( mysql_insert_id($this->connection) );
            $this->setName($name);
            $this->setDescription($desc);
        }
        return TRUE;
    }

    /**
     *  Get an Id based on a name
     * @param string $name
     * @return int Id
     */
    public function getIdByName($name){
        
        if ($this->checkText($name, $this->name_len) ){

            $query = "SELECT `".$this->id_field."`".
                    "FROM `".$this->table_name."`".
                    "WHERE `".$this->name_field ."` = '". $this->dbInString($name) . "'";

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
        
        return $status_array[$this->id_field];
    }

    /**
     * Get a name based on an Id
     *
     * @param int $id The ID from where the name is looked up.
     * @return string Name corresponding to the Id
     */
    public function getNameById($id){

        if ($this->checkId($id, $this->id_field)){

            $query = "SELECT `".$this->name_field."`".
                    "FROM `".$this->table_name."`".
                    "WHERE `".$this->id_field ."` = '". $id . "'";
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
        return ($status_array[$this->name_field]);
    }


    public function setId($id){
        if (!empty($id)){
            $this->id = trim($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function setDescription($txt){
        if (!empty($txt)){
            $this->desc = $txt;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function setName($txt){
        if (!empty($txt)){
            $this->name = $txt;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getDescription(){
        return $this->desc;
    }

    public function getName(){
        return $this->name;
    }

    public function getList(){
       //echo __FUNCTION__.' '.__FILE__. __LINE__;
       /*
        * Select all known statuses
        */
       $query = "SELECT `". $this->id_field ."`,`".
                            $this->name_field."`,`".
                            $this->desc_field."`".
                "FROM `". $this->table_name ."`";

       $this->dbquery($query);
       if ( $this->checkDbErrors($query) ){
            return FALSE;
       }
       $status_array = $this->dbFetchAll();

       return $status_array;

   }

    private function createTable(){

        /* TABLE Messagetype */
        $q =  "CREATE TABLE `".DB_NAME."`.`".$this->table_name."` (".
            "`". $this->id_field ."` BIGINT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,".
            "`". $this->name_field."` VARCHAR( ".$this->name_len." ) NOT NULL ,".
            "`". $this->desc_field."` VARCHAR( ".$this->desc_len." ) NOT NULL ,".
            " UNIQUE KEY `". $this->name_field."` (`". $this->name_field."`)".
            ") ENGINE = MYISAM";

        if ( !$this->dbquery($q)) {
            $this->checkDbErrors($q);
            return FALSE;
        }

    }
}
?>
