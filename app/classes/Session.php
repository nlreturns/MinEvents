<?php
namespace minevents\app\classes;

class Session {
    /*
     * Id van gebruiker
     * @var int
     */

    private $user_id;
    /*
     * Gebruikersnaam
     * @var string
     */
    private $username;
    /*
     * Rechten van gebruiker
     * @var int
     */
    //private $recht_positie;
    /*
     * Sessie
     * @var session
     */
    private $_SESSION;
    private $gebruiker_recht;

    /*
     * Constructor, maakt een nieuwe session
     */

    public function __construct() {
        session_start();
    }

    /*
     * kijk of de gebruiker al ingelogd is door controleren of sessie bestaat
     */

    public function isLoggedIn() {
        if ($this->_SESSION) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     * Maak de session aan
     */

    public function create($user) {
        //Set de user_id
        $this->user_id = $user[0]['gebruiker_id'];
        //Set de username
        $this->username = $user[0]['gebruiker_naam'];
        //Set de permission
        $this->gebruiker_recht = unserialize($user[0]['gebruiker_recht']);
        //zet user_id in session
        $_SESSION['user_id'] = $this->user_id;
        // Zet username in session
        $_SESSION['username'] = $this->username;
        // Zet rechten in session
        $_SESSION['gebruiker_recht'] = $this->gebruiker_recht;
        $this->_SESSION = $_SESSION;
        // Return de session
        return $_SESSION;
    }

    /*
     * Log de gebruiker uit, verwijder de session
     */

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['recht_positie']);
        unset($this->userid);
        $this->loggedIn = false;
        echo "Je bent uitgelogd.";
    }

    /*
     * set gebruiker_id
     */

    public function setUserId($value) {
        $this->gebruiker_id = $value;
    }

    /*
     * get gebruiker_id
     */

    public function getUserId() {
        return $this->gebruiker_id;
    }

    /*
     * set username
     */

    public function setUsername($username) {
        $this->username = $username;
    }

    /*
     * get username
     */

    public function getUsername() {
        return $this->username;
    }

    /*
     * set permission_rank
     */

    public function setPermission($permission) {
        $this->recht_positie = $permission;
    }

    /*
     * get permission_rank
     */

    public function getPermission() {
        return $this->recht_positie;
    }

}

?>
