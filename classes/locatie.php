<?php

//include_once FILE_DATABASE;
require_once 'error.php';
require_once 'db_locatie.php';

class Locatie  {
    private $naam = '';
    private $adres = '';
    
    public function __construct(){

    }
    
    public function save(){
    $save = new DbLocatie();
    $save->save($this->naam, $this->adres);
    }
    
    // Setters
    public function setNaam($naam) {
        $this->naam = $naam;
    }

    public function setAdres($adres) {
        $this->adres = $adres;
    }
    
    // Getters
    public function getNaam() {
        return $this->naam;
    }
    
    
    public function getAdres() {
        return $this->adres;
    }
    
}



?>
