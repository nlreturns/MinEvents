<?php
namespace minevents\app\classes\db;
/**
 * Description of db_rooster_persoonsgegevens
 *
 * @author Trinco Ingels 
 * @version 0.1
 */

class DbRoosterPersoonsgegevens extends database{

    private $persoon_id;
    private $rooster_id;
    private $taak;

    
public function DbRoosterPersoonsgegevens(){
        parent::__construct();

        /* Check whether the database already is created */
        if( !$this->dbTableExists(TBL_PERSOONSGEGEVENS)){
            $this->createTable();
        }
    }

   private function createTable(){
        /* Table Persoonsgegevens */    
       $query = "CREATE TABLE `".DB_NAME."`.`".TBL_PERSOONSGEGEVENS."` (".
            "`".FIELD_ROOSTER_PERSG_PERSOON_ID."` bigint( 10 ) NOT NULL ,".
            "`".FIELD_ROOSTER_ID."` bigint( 10 ) NOT NULL ,".
            "`".FIELD_ROOSTER_PERSG_PERSOON_TAAK."` varchar(".LEN_ROOSTER_PERSG_PERSOON_TAAK.") collate latin1_general_cs NOT NULL,".
            "PRIMARY KEY ( `".FIELD_ROOSTER_PERSG_PERSOON_ID."` )".
            ") ENGINE = MYISAM ";
        
 
        if ( !$this->dbquery($query)) {
            $this->checkDbErrors($query);
            return FALSE;
        }
    }
}
?>

