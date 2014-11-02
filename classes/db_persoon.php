<?php

/**
 * @version 1.3
 * @author Bjorn Faber
 * 
 * deze file doet:
 * - verbinding maken met DB
 * - de persoon tabel lezen/schrijven/updaten/deleten
 * 
 * */
require_once FILE_DB_DATABASE;

class DbPersoon extends Database {

    /**
     * ID van gebruiker.
     * @var type int
     */
    private $gebruiker_id;

    /**
     * ID van persoon.
     * @var int
     */
    private $persoon_id;

    /**
     * Dit is de achternaam van een persoon.
     * @var string
     */
    private $persoon_achternaam;

    /**
     * email van een persoon.
     * @var string
     */
    private $persoon_email;

    /**
     * het land waar de persoon is.
     * @var string
     */
    private $persoon_land;

    /**
     * Dit is de stad waar de persoon woont.
     * @var string
     */
    private $persoon_stad;

    /**
     * Dit is de straat waar de persoon woont.
     * @var string
     */
    private $persoon_straat;

    /**
     * Dit is de straat waar de persoon woont.
     * @var int
     */
    private $persoon_telnummer;

    /**
     * Dit is de voornaam van een persoon.
     * @var string
     */
    private $persoon_voornaam;

    /**
     * Calls Database's constructor. 
     * @param type $id
     * @return boolean
     */
    public function construct() {
        parent::__construct();
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
     * Get persoon ID.
     * @return type persoon_id
     */
    public function getPersoonId() {
        return $this->persoon_id;
    }

    /**
     * Get persoon achternaam.
     * @return type persoon_achternaam
     */
    public function getPersoonAchternaam() {
        return $this->persoon_achternaam;
    }

    /**
     * Get persoon email.
     * @return type persoon_email
     */
    public function getPersoonEmail() {
        return $this->persoon_email;
    }

    /**
     * Get persoon land.
     * @return type persoon_land
     */
    public function getPersoonLand() {
        return $this->persoon_land;
    }

    /**
     * Get persoon stad.
     * @return type persoon_stad
     */
    public function getPersoonStad() {
        return $this->persoon_stad;
    }

    /**
     * Get persoon straat.
     * @return type persoon_straat
     */
    public function getPersoonStraat() {
        return $this->persoon_straat;
    }

    /**
     * Get persoon telnummer.
     * @return type persoon_telnummer
     */
    public function getPersoonTelnummer() {
        return $this->persoon_telnummer;
    }

    /**
     * Get persoon voornaam.
     * @return type persoon_voornaam
     */
    public function getVoornaam() {
        return $this->persoon_voornaam;
    }

    /**
     * Add persoon.
     * @param type $gebruiker_id
     * @param type $persoon_voornaam
     * @param type $persoon_achternaam
     * @param type $persoon_email
     * @param type $persoon_land
     * @param type $persoon_stad
     * @param type $persoon_straat
     * @param type $persoon_telnummer
     * @return boolean
     */
    public function addPersoonDb($gebruiker_id, $persoon_voornaam, $persoon_achternaam, $persoon_email, $persoon_land, $persoon_stad, $persoon_straat, $persoon_telnummer) {
        $query = "INSERT INTO `minevents`.`persoon` (
                `persoon_voornaam`,
                `persoon_achternaam`,
                `persoon_email`,
                `persoon_land`,
                `persoon_stad`,
                `persoon_straat`,
                `persoon_telnummer`
                )
                VALUES (                 
                '" . mysql_real_escape_string($persoon_voornaam) . "',  
                '" . mysql_real_escape_string($persoon_achternaam) . "',  
                '" . mysql_real_escape_string($persoon_email) . "',  
                '" . mysql_real_escape_string($persoon_land) . "',  
                '" . mysql_real_escape_string($persoon_stad) . "',  
                '" . mysql_real_escape_string($persoon_straat) . "',        
                '" . mysql_real_escape_string($persoon_telnummer) . "'   
               );";
        if (!$this->dbquery($query)) {
            return false;
        } else {
            $this->gebruiker_id = $gebruiker_id;
            $this->persoon_voornaam = $persoon_voornaam;
            $this->persoon_achternaam = $persoon_achternaam;
            $this->persoon_email = $persoon_email;
            $this->persoon_land = $persoon_land;
            $this->persoon_stad = $persoon_stad;
            $this->persoon_straat = $persoon_straat;
            $this->persoon_telnummer = $persoon_telnummer;
            return true;
        }
    }

    /**
     * Delete een persoon.
     * @return boolean
     */
    public function deletePersoonDb($persoon_id) {

        $query = "DELETE FROM persoon WHERE persoon . persoon_id = '" . mysql_real_escape_string($persoon_id) . "'  LIMIT 1 ";


        if (!$this->dbquery($query)) {
            return false;
        }
    }

    /**
     * Selecteer persoon per ID.
     * @param type $persoon_id
     * @return boolean
     */
    public function getPersoonById($persoon_id) {
        // Query selecteert persoon aan de hand ingevoerde parameter.
        $query = "SELECT * FROM `persoon` WHERE 
            `persoon_id` =" . mysql_real_escape_string($persoon_id) . "";
        // haalt de array op aan de hand van database's fetchDbArray function.
        // als het null is,
        if ($this->fetchDbArray($query) == NULL) {
            return FALSE;
        } else {
            // als het niet null is, return the array.
            return $this->fetchDbArray($query);
        }
    }

    /**
     * Gets de volledige database array.
     * @return boolean
     */
    public function getPersoonListDb() {
        // Query selecteert de gebruiker aan de hand van class vars.
        $query = "SELECT * FROM  `persoon` ORDER BY  `persoon`.`persoon_achternaam` ASC";
        // haalt de array op aan de hand van database's fetchDbArray function.
        // als het null is,
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
     * Update persoon.
     * @param type $gebruiker_id
     * @param type $persoon_achternaam
     * @param type $persoon_email
     * @param type $persoon_land
     * @param type $persoon_stad
     * @param type $persoon_straat
     * @param type $persoon_telnummer
     * @param type $persoon_voornaam
     * @param type $persoon_id
     * @return boolean
     */
    public function updatePersoonDb($gebruiker_id, $persoon_voornaam, $persoon_achternaam, $persoon_email, $persoon_land, $persoon_stad, $persoon_straat, $persoon_telnummer, $persoon_id) {
        // Query updates the item using inserted parameters. 
        $query = "UPDATE `persoon` 
                    SET `gebruiker_id` = '" . mysql_real_escape_string($gebruiker_id) . "', 
                        `persoon_voornaam` = '" . mysql_real_escape_string($persoon_voornaam) . "'
                        `persoon_achternaam` = '" . mysql_real_escape_string($persoon_achternaam) . "', 
                        `persoon_email` = '" . mysql_real_escape_string($persoon_email) . "', 
                        `persoon_land` = '" . mysql_real_escape_string($persoon_land) . "', 
                        `persoon_stad` = '" . mysql_real_escape_string($persoon_stad) . "', 
                        `persoon_straat` = '" . mysql_real_escape_string($persoon_straat) . "',  
                        `persoon_telnummer` = '" . mysql_real_escape_string($persoon_telnummer) . "' WHERE                              
                        `persoon_id` =" . mysql_real_escape_string($persoon_id);

        if (!$this->dbquery($query)) {
            return false;
        } else {
            $this->gebruiker_id = $gebruiker_id;
            $this->persoon_voornaam = $persoon_voornaam;
            $this->persoon_achternaam = $persoon_achternaam;
            $this->persoon_email = $persoon_email;
            $this->persoon_land = $persoon_land;
            $this->persoon_stad = $persoon_stad;
            $this->persoon_straat = $persoon_straat;
            $this->persoon_telnummer = $persoon_telnummer;
            $this->persoon_id = $persoon_id;
        }
    }

}
?>
