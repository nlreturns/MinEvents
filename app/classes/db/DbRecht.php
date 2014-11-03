<?php
namespace minevents\app\classes\db;

class DbRecht extends Database {

        private $recht_positie;
        private $recht_onderdeel;
        private $recht_beschrijving;

	public function __construct() {
        parent::__construct();
	}

    // Getters
    /*public function getRecht_id() {
        return $this->recht_id;
    }*/

    public function getRecht_onderdeel() {
        return $this->recht_onderdeel;
    } 
    
    public function getRecht_positie() {
        return $this->recht_positie;
    }
    
    public function getRecht_beschrijving() {
        return $this->recht_beschrijving;
    }
    
    // Setters
    /*
     public function setRecht_id($recht_id) {
        $this->recht_id = $recht_id;
    }
    //*/

    public function setRecht_onderdeel($recht_onderdeel) {
        $this->recht_onderdeel = $recht_onderdeel;
    }
    
 
      public function setRecht_positie($recht_positie) {
 
        $this->recht_positie = $recht_positie;
    }
   
    public function setRecht_beschrijving($recht_beschrijving) {
        $this->recht_beschrijving = $recht_beschrijving;
    }

        
    public function getRecht(){
        $this->dbquery("SELECT * FROM recht WHERE 
                        recht_positie = '" . mysql_real_escape_string($this->recht_positie) . "'");

        if ($this->dbNumRows() == 1) {
            
            $result = $this->dbFetchArray();
            
            //$this->recht_id = $result['recht_id'];
            $this->recht_positie = $result['recht_positie'];
            $this->recht_onderdeel = $result['recht_onderdeel'];
            $this->recht_beschrijving = $result['recht_beschrijving'];
            
        } else {
            return false;
        }
        }
            
    public function getRechtOnderdeelList(){
        
        $this->dbquery("SELECT recht_positie, recht_onderdeel FROM recht GROUP BY recht_onderdeel ORDER BY recht_positie");

        if ($this->dbNumRows() >= 1) {
 
            return $this->dbFetchAll();
            
        } else {
            return false;
    }
}
    
    public function getRechtBeschrijvingList(){
        
        $this->dbquery("SELECT recht_positie, recht_beschrijving FROM recht GROUP BY recht_beschrijving ORDER BY recht_positie");

        if ($this->dbNumRows() >= 1) {
 
            return $this->dbFetchAll();
            
        } else {
            return false;
        }
    }
    
    public function getRechtList($onderdeel = null){
        
        if($onderdeel == null){
            $this->dbquery("SELECT * FROM recht");
        } else {
            $this->dbquery("SELECT * FROM recht WHERE recht_onderdeel = '" . mysql_real_escape_string($onderdeel) . "'");
        }
        
        if ($this->dbNumRows() >= 1) {
            
            return $this->dbFetchAll();
            
        } else {
            return false;
        }
    }
    
    public function getGebruikersRechtenList(){
        
        $this->dbquery("SELECT * FROM (`gebruiker` AS G
                        INNER JOIN `persoon` AS P
                        ON G.gebruiker_id = P.gebruikers_id)
                        INNER JOIN `recht_groep` AS R
                        ON R.recht_groep_id = G.recht_groep_id");
        
        if ($this->dbNumRows() >= 1) {
            
            return $this->dbFetchAll();
            
        } else {
            return false;
        }
    }
    
    public function saveRecht(){
        $this->dbquery("INSERT INTO recht (recht_onderdeel, recht_beschrijving) 
                        VALUES ('" . mysql_real_escape_string($this->recht_onderdeel) . "',
                                '" . mysql_real_escape_string($this->recht_beschrijving) . "')");
        
        $this->recht_positie = mysql_insert_id();
    }
    
    public function updateRecht(){
        $this->dbquery("UPDATE recht SET recht_onderdeel = '" . mysql_real_escape_string($this->recht_onderdeel) . "',
                                         recht_beschrijving = '" . mysql_real_escape_string($this->recht_beschrijving) . "'
                        WHERE recht_positie ='" . mysql_real_escape_string($this->recht_positie) . "'");
    }
    
    public function deleteRecht(){
        $this->dbquery("DELETE FROM recht WHERE recht_positie ='" . mysql_real_escape_string($this->recht_positie) . "'");
    }
}

class TestDbRecht {

    public function __construct() {
        try {
            $test = new DbRecht();

            echo '<pre>';
            var_dump($test);
            echo '</pre>';
        } catch (Exception $e) {
            echo '<pre>';
            echo $e->getTraceAsString();
            echo '</pre>';
            trigger_error($e->getMessage());
        }
    }

}

?>