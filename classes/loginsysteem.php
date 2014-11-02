<?php
include_once 'classes/defs/constants.php';
require FILE_DB_LOGIN;
require FILE_SESSION;
//require FILE_GEBRUIKER;

class Login {
	
	/*
	* Naam gebruiker
	* var @string
	*/
	private $username;
	/*
	* wachtwoord gebruiker
	* var @string
	*/
	private $password;
	/*
	* database object
	* 
	*/
	private $db;
	/*
	* session object
	* 
	*/
	public $session;
	/*
	* object van GEbruiker
	* 
	*/
	private $user;
        private $dbuser;
	/*
	* Constructor
	*/
	public function __construct() {
		// Nieuw object van Gebruiker
		$this->user = new Gebruiker(new DbGebruiker());
                $this->dbuser = new DbGebruiker();
		// Nieuw object van DbLoginSysteem
		$this->db = new DbLoginSysteem;
		// Nieuw object van Session
		$this->session = new Session;
	}

	/*
	* Controleer of inloggegevens kloppen
	*/
	public function authenticate() {
		// Voer authenticate functie in DbLoginSysteem uit
		return $this->db->authenticate($this->username, $this->password);
	}

	/*
	* controleer of de gebruiker al ingelogd is
	*/
	public function isloggedin() {
		if(isset($_SESSION['username'])) {
			// Return true als session bestaat
			return true;
		} else {
			// Zoniet, return dan false
			return false;
		}
	}

	/*
	* Voert controles uit, maakt dan session aan en dan ben je ingelogd :D 
	*/
	public function login() {
		// Kijk of je nog niet ingelogd bent
		if(!$this->isloggedin()) {
			// Zoniet, kijk of gegevens kloppen
			if($this->authenticate()) {
				// Haal gebruikergegevens op en maak session aan.
				$user = $this->dbuser->getGebruikerbyUsername($this->username);
				return $this->session->create($user);
			} else {
				// Als gegevens niet kloppen laat dan dit zien.
				echo "Naam of wachtwoord is fout.";
			}
		} else {
			// Als je wel al ingelogd bent
			echo "U bent al ingelogd.";
		}
	}

	/*
	* Voer functie in Session uit.
	* Logt de gebruiker uit
	*/ 
	public function logout() {
		$this->session->logout();
	}

	/*
	* Set de username attribuut
	*/
	public function setUsername($username) {
		$this->username = $username;
	}

	/*
	* get de username attribuut
	*/
	public function getUsername() {
		return $this->username;
	}

	/*
	* Set de password attribuut en hash hem met sha1
	*/
	public function setPassword($password) {
		$this->password = md5($password);
	}

	/*
	* get de password attribuut
	*/
	public function getPassword() {
		return $this->password;
	}
}
?>