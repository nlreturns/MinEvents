<?php

namespace minevents\app\classes\db;
/**
 * Description of database
 *
 * @author GHoogendoorn
 * @version 0.1
 *  
 * Version history:
 * 0.1                GHoogendoorn    Initial version
 * 0.2                GHoogendoorn    Added create database.
 * 0.3  - 30.10.2014  Jan-Willem Dooms <janwillem.dooms@gmail.com>  MySQL to MySQLi conversion
 *
 */
use minevents\app\classes\Error;


//require_once WWW_ROOT.'../lang/nl/planningsysteem.php';

//include_once '../lang/nl/general.php';
class Database extends Error {
    protected   $connection;         //The MySQL database connection
    private     $query_result;

    public function __construct(){
    

    /* Make connection to database */
      $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS, TRUE /* New link */) or die(mysql_error());
      if (! $this->connectDatabase() ){
          // Check db existance (Firsth time create)
          if ( mysql_errno() == 1049 ){
              if ($this->createDatabase()){

                  // If still error just stop
                  $this->connectDatabase() or die(mysql_error());

              }
          } else {
               die(mysql_error());
          }
      }
      //echo "<br />". __FILE__ . ' ' . __LINE__ . ' '. "<strong>OPENED DB #". $this->connection ."</strong><br />";

    //parent::__construct();

    
}
    
    /**
     *
     * @return string  '' | mysqlerrno()-mysql error txt [query]
     */
    protected function getDbError(){
        if (mysql_errno()){
            return mysql_errno(). '-'. mysql_error(). " [$query]";
        }
        return '';
    }

    /**
     *
     * The function checks the mysql error.
     * If found an error is triggered.
     * @param string $query
     * @return bool FALSE (Ok) or TRUE The error array is set, and should be checked.
     */
    protected function checkDbErrors($query){
        if (mysql_errno()) {
            switch( mysql_errno()){
                case 1062:
                    $this->setError( TXT_ERROR_DUPLICATE_ENTRY );
                    break;

                default:
                    $error = "MySQL error ".mysql_errno().": ".
                        mysql_error()."\n<br><br>\n$query\n<br>";
                    $this->setError($error);
                    break;
            }

            return TRUE;
       }
       return FALSE;
   }

   /**
    * query - Performs the given query on the database and
    * returns the result, which may be false, true or a
    * resource identifier.
    * @param string $query
    * @return bool TRUE if Ok | FALSE check error array
    */
   protected function dbquery($query){
       $this->query_result = mysql_query($query);
       return $this->query_result;
   }

   /**
     *
    *  Gerhard Hoogendoorn
     * @param array $data_array The result from a mysql_fetch_array()
     * @return array the modified input array
     */
    protected function dbOutArray($data_array){

        foreach( $data_array as $field => $value ){
            if( is_numeric($value)){
                continue;
            } else if (is_string($value)){
                $data_array[$field] = $this->dbOutString($value);
            }
        }
        return $data_array;
    }


   /**
    * Get the single results from the database
    * This function also removes the database escapes.
    *
    * @return array The array contains the elements of mysql_fetch_array
    * 
    * @return FALSE No data was found.
    */
    protected function dbFetchArray($query){        
        if (!$this->isMySqlResource($query)){
            return FALSE;
        }
        //TODO: add error check.	
        $data_array = mysql_fetch_array($query, MYSQL_ASSOC);

        if ($data_array === FALSE){
            return FALSE;
        }

        if(!mysql_errno()){
            $data_array = $this->dbOutArray($data_array);
        }
        return $data_array;
    }

    protected function dbNumRows(){
        if ($this->isMySqlResource($this->query_result)){
            return mysql_num_rows($this->query_result);
        } else {
            return FALSE;
        }
    }

    /**
    * Get multiple results from the database
    * This function also removes the database escapes.
    *
    * @return array The array contains an array with the row elements
    *
    * @return FALSE No succesfull query was found.
    */
    protected function dbFetchAll(){
        if (!is_resource($this->query_result)){
            return FALSE;
        }
        $return_array = array();

        while ($row = mysql_fetch_array( $this->query_result, MYSQL_ASSOC ) ) {
           $return_array[] = $this->dbOutArray($row);
        }
        return $return_array;
    }

   /**
    *
    * @param string $table MySql table name
    * @return bool TRUE if exists | False if not exists
    */
   protected function dbTableExists($table){
        $query = "DESC ". $table;
        $result = $this->dbquery($query);

        if ($result = (mysql_errno()==1146)){
            return FALSE;
        }
        return TRUE;
    }

    /**
     * The function escapes a string.
     *  This function should be called before storage
     *  in the database.
     *
     * @param string $string
     * @return string
     */
    protected function dbInString($string) {

        if (function_exists('mysql_real_escape_string')) {
          return mysql_real_escape_string($string, $this->connection);
        } elseif (function_exists('mysql_escape_string')) {
          return mysql_escape_string($string);
        }

        return addslashes($string);
    }

    /**
     * The function removes the escapes from a database returned string.
     *  This function should be called after the database query.
     *
     * @param string $string
     * @return string
     */
    protected function dbOutString($string) {
        if (is_string($string)) {
          return trim(stripslashes($string));
        }
    }

    /**
     * Just reset the query resource link
     * 
     */
    protected function dbReset(){
        $this->query_result = '';
    }
    protected function checkText($text, $len){
        if (    empty($text)            ||
                (!is_string($text))     ||
                (strlen($text) > $len )) {
            return FALSE;
        }
        return TRUE;
    }


    /**
     *
     * @param int $id A database Id.
     * @param string $field Datase field name
     * @return bool TRUE (ok) or FALSE  The error array is set, 
     *                                  and should be checked
     */
    protected function checkId($id, $field){
         if ( !is_numeric($id)){
            $this->setError( TXT_ERROR_WRONG_VAR_TYPE . " [$id] ". $field);
            return FALSE;
        }
        return TRUE;

    }

    /**
     *
     * @param resource $res The resource that should be checked
     * @return bool TRUE if $res is mysql resource | FALSE any other case
     * (check error array)
     */
    private function isMySqlResource($res){
        $res_type = is_resource($res) ? get_resource_type($res) : gettype($res);

        if (strpos($res_type, 'mysql') === FALSE)
        {
            echo 'Invalid resource type: '.$res_type;
            return FALSE;
        }
        return TRUE;
    }

    private function connectDatabase(){
        return mysql_select_db(DB_NAME, $this->connection);
    }

    private function createDatabase(){
        $query = "CREATE DATABASE ". DB_NAME;
        return $this->dbquery($query);
    }
    public function __destruct(){

        //echo "<br />". __FILE__ . ' ' . __LINE__ . ' '. "<strong>CLOSE DB #". $this->connection ."</strong><br />";
        

    }
}
?>
