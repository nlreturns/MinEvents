<?php

/**
 * Dit is de klasse persoon.
 * Klassen om gebruikers te registreren, aan te passen,
 * verwijderen of op te  halen ter controle.
 * 
 * @version 0.1
 * @author Bjorn Faber
 * 
 */
namespace minevents\app\classes;

use minevents\app\classes\db\DbGebruiker;

class Gebruiker {

    /**
     * ID van gebruiker.
     * @var int
     */
    private $gebruiker_id;

    /**
     * Dit is de login naam van een persoon.
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
    
    
    // the dbGebruiker object
    private $dbGebruiker;

    /**
     * Dit is de constructor. Hier zet ik de klasse variabelen aan de hand
     * van  een parameter.
     * @param $db
     */
    public function __construct(DbGebruiker $db = null) {
        $this->dbGebruiker = $db;
        $this->rechten = new RechtBitfield();
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
     * Get gebruiker by ID.
     * @param type $gebruiker_id
     * @return type
     */
    public function getGebruikerById($gebruiker_id) {
        
        return $this->dbGebruiker->getGebruikerByIdDb($gebruiker_id);
    }

    /**
     * Get gebruikerlist.
     * @return type gebruikerListDb
     */
    public function getGebruikerList() {
        return $this->dbGebruiker->getGebruikerListDb();
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
    public function getSessieId() {
        return $this->sessie_id;
    }

    /**
     * @return type gebruiker_wachtwoord
     */
    public function getGebruikerWachtwoord() {
        return $this->gebruiker_wachtwoord;
    }

    /**
     * Get gebruikersrecht.
     */
    public function getGebruikersRecht() {
        $this->setGebruikerId($this->gebruiker_id);
        return $this->getGebruikersRecht();
    }

    //Setters

    /**
     * Set gebruiker ID.
     */
    public function setGebruikerId($gebruiker_id) {
        $this->gebruiker_id = $gebruiker_id;
    }

    public static function getRechtgroepById() {
        
    }

    public function setRecht($rechten) {
        $this->rechten = $rechten;
    }

    /**
     * Set login naam.
     * Als de login naam leeg is krijg je een error.
     */
    public function setGebruikerNaam($gebruiker_naam) {
        if (empty($gebruiker_naam)) {
            throw new Exception(GEBRUIKER_ERROR_GEENUSERNAME);
        }
        $this->gebruiker_naam = $gebruiker_naam;
    }

    /**
     * Set login tijd.
     */
    public function setGebruikerTijd($gebruiker_tijd) {
        if (empty($gebruiker_tijd)) {
            return false;
        }
        $this->gebruiker_tijd = $gebruiker_tijd;
    }

    /**
     * Set recht groep ID.
     * 
     */
    public function setRechtGroepId($recht_groep_id) {
        if ((!strlen($recht_groep_id) > 0) || !is_numeric($recht_groep_id)) {
            throw new Exception(GEBRUIKER_ERROR_GEENRECHTENID);
        }
        $this->recht_groep_id = $recht_groep_id;

        // Set gebruikers rechten initieel op de rechten van deze groep
        //RechtGroep::getRechtgroepById($id);
    }

    /**
     * Set sessie ID.
     */
    public function setSessieId($sessie_id) {
        $this->sessie_id = $sessie_id;
    }

    /**
     * Set wachtwoord.
     * Als het wachtwoord leeg staat krijg je een error.
     */
    public function setGebruikerWachtwoord($gebruiker_wachtwoord) {
        $this->gebruiker_wachtwoord = $gebruiker_wachtwoord;
    }

    /**
     *
     * Set Oudewachtwoord.
     * @param type $oude_wachtwoord
     * @throws Exception
     */
    public function setOudeWachtwoord($oude_wachtwoord) {
        if (empty($oude_wachtwoord)) {
            throw new Exception(GEBRUIKER_ERROR_GEENWACHTWOORD);
        }
        $this->oude_wachtwoord = $oude_wachtwoord;
    }

    /**
     * De save functie wordt gebruikt om een gebruiker op te slaan in de
     * database.
     */
    public function addGebruiker($rechten) {
        $this->dbGebruiker->addGebruikerDb($this->gebruiker_naam, $rechten, $this->sessie_id, md5($this->gebruiker_wachtwoord));


        // Sla recht op basis van rechtgroep id (gebruiker_recht tabel)
    }

    /**
     * check de lengte van het wachtwoord.
     * @param type $gebruiker_wachtwoord
     * @return boolean
     */
    public function checkLengteWachtwoord($gebruiker_wachtwoord) {
        if (strlen($gebruiker_wachtwoord) < 8) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * De delete functie wordt gebruikt om een gebruiker te deleten uit de
     * database.
     */
    public function deleteGebruiker() {
        $this->dbGebruiker->deleteGebruikerDb($this->gebruiker_id);
    }

    /**
     * De update functie wordt gebruikt om een gebruiker uptedaten als er
     * data  veranderd.
     */
    public function updateGebruiker($rechten) {
        $this->dbGebruiker->updateGebruikerDb($this->gebruiker_naam, $rechten, $this->sessie_id, $this->gebruiker_wachtwoord, $this->gebruiker_id);
    }

    /**
     * De update login time functie wordt gebruikt om de login time
     * up-to-date  te brengen.
     */
    public function updateLoginTime() {
        $this->updateLoginTime($this->login_tijd);
    }

    /**
     * met deze functie kun je de gebruiker recht groep veranderen.
     */
    public function updateGebruikerRechtGroep() {

        echo __FUNCTION__ . ' ' . __FILE__ . __LINE__ . '<br />';
        /*
          echo '<pre>';
          var_dump($this->recht_groep_id);
          echo '</pre>';
          // */
        $this->updateGebruikerRechtGroep($this->recht_groep_id, $this->gebruiker_id);
    }

    /**
     * Deze functie zorgt dat het wachtwoord geupdate kan worden.
     */
    public function updateWachtwoord() {
        if ($this->checkWachtwoord($this->oude_wachtwoord) == true) {
            if ($this->wachtwoordBestaat($this->gebruiker_wachtwoord) == false) {
                if ($this->updateWachtwoord($this->gebruiker_wachtwoord) == true) {

                    return true;
                }
            }
        }
    }

    /**
     * Funtie die kijkt of het wachtwoord bestaat.
     * @return boolean
     */
    public function wachtwoordBestaat() {
        // Function $db_gebruiker->wachtwoordBestaat() returns true when password excists.
        if ($this->wachtwoordBestaat($this->gebruiker_wachtwoord) == TRUE) {
            return TRUE;
        }
    }

    public function addRecht($recht_positie) {
        $this->rechten->addRecht($recht_positie);
    }

    /**
     * Opslaan van recht: is overschrijven van huidig recht
     * @return bool
     */
    public function saveRecht() {
        // array serializen
        // saven in db
        return true;
    }

    public function heeftRecht($gebruiker_recht, $recht_positie) {
        $this->rechten->setBitfield($gebruiker_recht);
        if ($this->rechten->heeftRecht($recht_positie)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getGebruikerbyUsername($username) {
        return $this->dbGebruiker->getGebruikerbyUsername($username);
    }
}
