<?php

namespace minevents\app\classes\db;

/**
 * @version 1.3
 * @author Bjorn Faber
 * 
 * deze file doet:
 * - verbinding maken met DB
 * - de gebruiker tabel lezen/schrijven/updaten/deleten
 * 
 * */

class DbGebruiker extends Database {

    /**
     * ID van gebruiker.
     * @var int
     */
    private $gebruiker_id;

    /**
     * Dit is de login naam van een gebruiker.
     * @var string
     */
    private $gebruiker_naam;

    /**
     * Dit is de login tijd van een gebruiker.
     * @var string
     */
    private $gebruiker_tijd;

    /**
     * ID van recht groep.
     * @var int
     */
    private $recht_groep_id;
    private $rechten;

    /**
     * ID van sessie.
     * @var int
     */
    private $sessie_id;

    /**
     * Dit is het wachtwoord van een gebruiker.
     * @var string
     */
    private $gebruiker_wachtwoord;

    /**
     * Calls Database's constructor. 
     * @param type $id
     * @return boolean
     */
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    // Getters

    /**
     * Get gebruiker ID.
     * @return type gebruiker_id
     */
    public function getGebruikerId() {
        return $this->gebruiker_id;
    }

    /**
     * Get login naam.
     * @return type gebruiker_naam
     */
    public function getGebruikerNaam() {
        return $this->gebruiker_naam;
    }

    /**
     * Get recht groep ID.
     * @return type recht_groep_id
     */
    public function getRechtGroepId() {
        return $this->recht_groep_id;
    }

    /**
     * Get sessie ID.
     * @return type sessie_id
     */
    public function getSessie_Id() {
        return $this->sessie_id;
    }

    /**
     * @return type gebruiker_wachtwoord
     */
    public function getGebruikerWachtwoord() {
        return $this->gebruiker_wachtwoord;
    }
    
    /**
     * add een gebruiker.
     * @param type $gebruiker_naam
     * @param type $recht_groep_id
     * @param type $sessie_id
     * @param type $wachtwoord
     * @return boolean
     */
    public function addGebruikerDb($gebruiker_naam, $rechten, $sessie_id, $gebruiker_wachtwoord) {
        $rechten = serialize($rechten);
        $query = "INSERT INTO  `minevents`.`gebruiker` (
                `gebruiker_id` ,
                `gebruiker_naam` ,
                `gebruiker_tijd` ,
                `gebruiker_recht` ,
                `sessie_id` ,
                `gebruiker_wachtwoord`
                )
                  VALUES (
                NULL, 
                '" . mysql_real_escape_string($gebruiker_naam) . "', 
                CURRENT_TIMESTAMP ,
                '" . mysql_real_escape_string($rechten) . "',
                '" . mysql_real_escape_string($sessie_id) . "',  
                '" . $gebruiker_wachtwoord . "'
                );";
        
        if (!$this->db->dbquery($query)) {
            return false;
        } else {
            $this->gebruiker_naam = $gebruiker_naam;
            $this->sessie_id = $sessie_id;
            $this->gebruiker_wachtwoord = $gebruiker_wachtwoord;
            return true;
        }
    }

    /**
     * Delete een gebruiker.
     * @return boolean
     */
    public function deleteGebruikerDb($gebruiker_id) {

        $query = "DELETE FROM gebruiker WHERE gebruiker . gebruiker_id = '" . mysql_real_escape_string($gebruiker_id) . "'  LIMIT 1 ";

        if (!$this->db->dbquery($query)) {
            return false;
        }
    }
    /**
     * Selecteer gebruiker per gebruikers.
     * @param type $username
     * @return array
     */
    public function getGebruikerbyUsername($username) {
        $query = "SELECT * FROM gebruiker WHERE gebruiker_naam = '$username'";
        $this->db->dbquery($query);
        $user = $this->db->dbFetchAll($query);
        if ($user == NULL) {
            return FALSE;
        } else {
            // als het niet null is, return the array.
            return $user;
        }
    }
    /**
     * Selecteer gebruiker per ID.
     * @param type $gebruiker_id
     * @return boolean
     */
    public function getGebruikerByIdDb($gebruiker_id) {
        // Query selecteert gebruiker aan de hand ingevoerde parameter.
        $query = "SELECT * FROM `gebruiker` WHERE 
            `gebruiker_id` = " . mysql_real_escape_string($gebruiker_id);
        // haalt de array op aan de hand van database's fetchDbArray function.
        // als het null is,
        //$result = $this->db->dbquery($query);
        
        $data = $this->db->dbFetchArray($query);
        
        if ( $data == NULL) {
            return FALSE;
        } else {
            // als het niet null is, return the array.
            $data['gebruiker_recht'] = unserialize($data['gebruiker_recht']);
            
            return $data;
        }
    }

    /**
     * Gets de volledige database array.
     * @return boolean
     */
    public function getGebruikerListDb() {
        // Query selecteert de gebruiker aan de hand van class vars.
        $query = "SELECT * FROM  `gebruiker` ORDER BY  `gebruiker`.`gebruiker_naam` ASC";
        // haalt de array op aan de hand van database's fetchDbArray function.
        // als het null is,
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

    /**
     * Update de gebruiker.
     * @param type $gebruiker_naam
     * @param type $recht_groep_id
     * @param type $sessie_id
     * @param type $wachtwoord
     * @param type $gebruiker_id
     * @return boolean
     */
    public function updateGebruikerDb($gebruiker_naam, $rechten, $sessie_id, $gebruiker_wachtwoord, $gebruiker_id) {
        // serialize rights
        $rechten = serialize($rechten);
        // Query updates the item using inserted parameters. 
        $query = "UPDATE `gebruiker` 
                    SET `gebruiker_naam` = '" . mysql_real_escape_string($gebruiker_naam) . "', 
                        `gebruiker_recht` = '" . mysql_real_escape_string($rechten) . "', 
                        `sessie_id` = '" . mysql_real_escape_string($sessie_id) . "', 
                        `gebruiker_wachtwoord` = '" . mysql_real_escape_string($gebruiker_wachtwoord) . "' WHERE   
                        `gebruiker_id` =" . mysql_real_escape_string($gebruiker_id);
        
        if (!$this->db->dbquery($query)) {
            return false;
        } else {
            $this->gebruiker_naam = $gebruiker_naam;
            $this->rechten = $rechten;
            $this->sessie_id = $sessie_id;
            $this->gebruiker_wachtwoord = $gebruiker_wachtwoord;
            $this->gebruiker_id = $gebruiker_id;
        }
    }

}

?>
