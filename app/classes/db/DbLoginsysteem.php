<?php
namespace minevents\app\classes\db;

class DbLoginsysteem extends Database {



	/*
	* Kijk of ingevulde gegevens kloppen
	* 
	*/
	public function authenticate($username, $password) {
		// Selecteer het account waarbij de gebruikersnaam en wachtwoord overeen komen met ingevulde gegevens
		$sql = "SELECT * FROM gebruiker WHERE gebruiker_naam = '$username' AND gebruiker_wachtwoord = '$password' LIMIT 1";
		$result=$this->dbquery($sql);
		//Kijk of er resultaten zijn
		$count=mysql_num_rows($result);
		return $count;
	}
}
?>