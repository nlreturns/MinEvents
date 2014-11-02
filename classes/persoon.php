<?php

/**
 * Dit is de klasse persoon.
 * Deze klasse maakt het aanmaken van een nieuwe persoon, bewerken en deleten mogelijk. 
 * 
 * @version 0.1
 * @author Bjorn Faber
 * 
 */
require_once FILE_DB_PERSOON;

class Persoon extends DbPersoon {

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
     * Dit is de constructor. Hier zet ik de klasse variabelen aan de hand van een parameter.
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
     * Get gebruiker by ID.
     * @param type $persoon_id
     * @return type
     */
    public function getPersoonById($persoon_id) {
        return $this->getPersoonByIdDb($persoon_id);
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
     * Get gebruikerlist.
     * @return type PersoonListDb
     */
    public function getPersoonList() {
        return $this->getPersoonListDb();
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

    //Setters

    /**
     * Set gebruiker ID.
     */
    public function setGebruikerId($gebruiker_id) {
        $this->gebruiker_id = $gebruiker_id;
    }

    /**
     * Set persoon ID.
     * @param type $persoon_id
     */
    public function setPersoonId($persoon_id) {
        $this->persoon_id = $persoon_id;
    }

    /**
     * Set achternaam.
     * @param type $persoon_achternaam
     */
    public function setPersoonAchternaam($persoon_achternaam) {
        $this->persoon_achternaam = $persoon_achternaam;
    }

    /**
     * Set persoon email.
     * @param type $persoon_email
     */
    public function setPersoonEmail($persoon_email) {
        $this->persoon_email = $persoon_email;
    }

    /**
     * Set persoon land.
     * @param type $persoon_land
     */
    public function setPersoonLand($persoon_land) {
        $this->persoon_land = $persoon_land;
    }

    /**
     * Set persoon stad.
     * @param type $persoon_stad
     */
    public function setPersoonStad($persoon_stad) {
        $this->persoon_stad = $persoon_stad;
    }

    /**
     * Set persoon straat.
     * @param type $persoon_straat
     */
    public function setPersoonStraat($persoon_straat) {
        $this->persoon_straat = $persoon_straat;
    }

    /**
     * Set persoon telnummer.
     * @param type $persoon_telnummer
     */
    public function setPersoonTelnummer($persoon_telnummer) {
        $this->persoon_telnummer = $persoon_telnummer;
    }

    /**
     * set persoon voornaam.
     * @param type $persoon_voornaam
     */
    public function setPersoonVoornaam($persoon_voornaam) {
        $this->persoon_voornaam = $persoon_voornaam;
    }

    /**
     * De save functie wordt gebruikt om een persoon op te slaan in de database.
     */
    public function addPersoon() {
        return $this->addPersoonDb($this->gebruiker_id, $this->persoon_voornaam, $this->persoon_achternaam, $this->persoon_email, $this->persoon_land, $this->persoon_stad, $this->persoon_straat, $this->persoon_telnummer);
    }

    /**
     * De delete functie wordt gebruikt om een persoon te deleten uit de database.
     */
    public function deletePersoon() {
        $this->deletePersoonDb($this->persoon_id);
    }

    /**
     * De update functie wordt gebruikt om een persoon uptedaten als er data veranderd.
     */
    public function updatePersoon() {
        $this->updatePersoonDb($this->gebruiker_id, $this->persoon_achternaam, $this->persoon_voornaam, $this->persoon_email, $this->persoon_land, $this->persoon_stad, $this->persoon_straat, $this->persoon_telnummer, $this->persoon_id);
    }

}

?>
