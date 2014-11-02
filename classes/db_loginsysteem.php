<?php
include_once FILE_DATABASE;

class DbLoginSysteem extends Database {

	/*
	* Object van database
	*/
	private $db;

	/*
	* Constructor
	*/
	public function __construct() {
		$this->db = new Database;
	}

	/*
	* Kijk of ingevulde gegevens kloppen
	* 
	*/
	public function authenticate($username, $password) {
		// Selecteer het account waarbij de gebruikersnaam en wachtwoord overeen komen met ingevulde gegevens
		$sql = "SELECT * FROM gebruiker WHERE gebruiker_naam = '$username' AND gebruiker_wachtwoord = '$password' LIMIT 1";
		$result=$this->db->dbquery($sql);
		//Kijk of er resultaten zijn
		$count=mysql_num_rows($result);
		return $count;
	}
}
?>