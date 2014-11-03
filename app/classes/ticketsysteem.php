<?php

namespace minevents\app\classes;
use minevents\app\classes\Afdeling as Afdeling;
use minevents\app\classes\db\DbTicket as DbTicket;

/**
 * This is the class that facilitates
 *  the ticketsysteem functionality.
 *
 * @author Donny van Walsem
 * @version 0.4
 * 
 * Version History :
 * 0.1  Initial version.
 * 0.2 Added set and get functions
 * 0.3 Connected setters with Save function
 * 0.4 Added createdate function
 */
class TicketSysteem {

    /**
     * @var string afdeling 
     */
    private $afdeling;

    /**
     * @var string object 
     */
    private $object;

    /**
     * @var string titel 
     */
    private $titel;

    /**
     * @var string beschrijving 
     */
    private $beschrijving;

    /**
     * @var string Progress 
     */
    private $progress;

    /**
     * @var string createdate 
     */
    private $createdate;

    /**
     * @var string prioid 
     */
    private $prioid;

    /**
     * @var database
     */
    private $db;
    /*
     * @var messageboard
     */
    private $message;
    /*
     * @var creator
     */
    private $creator_id;

    public function __construct() {
        /**
         * @var db New instance of DbTicket
         */
        $this->db = new DbTicket();
        $this->afdeling = new Afdeling();
        $this->object = new Object();
        $this->message = new MessageBoard();
    }

    /**
     * Voeg een nieuwe ticket toe aan database.
     */
    public function saveTicket() {
        /**
         * @var db set afdelingid
         */
        $this->db->setAfdelingId($this->afdeling);
        /**
         * @var db set objectid
         */
        $this->db->setObjectId($this->object);
        /**
         * Create ticket
         * @var string titel
         * @var string beschrijving
         * @var string progress
         * @var string createdate
         */
        $this->db->createTicket($this->creator_id, $this->titel, $this->beschrijving, $this->progress, $this->createdate);
        
        $ticket_id = mysql_insert_id();
        
        $this->message->newMessage("Nieuw ticket toegevoegt: " . $this->titel, $ticket_id);
    }

    /**
     * Haal een ticket op gebasseerd op de ticket id
     */
    public function getTicketByID($ticket_id) {
        /**
         * Get ticket by ID.
         * @param type $ticket_id
         * @return type
         */
        return $this->db->getDbTicketByID($ticket_id);
    }

    public function getTicket($id) {
        return $this->db->getDbTicket($id);
    }

    /**
     * Verwijderd een bestaande ticket uit de database
     */
    public function deleteTicket($id) {
        if (is_numeric($id)) {
            $this->db->deleteTicket($id);
        }
    }

    /**
     * Update een bestaande ticket in de database.
     */
    public function updateTicket() {
        /**
         * @var db set afdelingid
         */
        //var_dump($this->afdeling);
        $this->db->setAfdelingId($this->afdeling);
        /**
         * @var db set objectid
         */
        $this->db->setObjectId($this->object);
        /**
         * Create ticket
         * @var string titel
         * @var string beschrijving
         * @var string progress
         * @var string createdate
         */
        //titel pers_id afdeling object beschrijving progress prioid ticketstatus ticket_end_tijd
        $this->db->updateTicket($this->titel, $this->pers_id, $this->afdeling, $this->object, $this->beschrijving, $this->progress, $this->prioid, $this->ticket_status_id, $this->ticket_end_tijd);

        if($this->ticket_status_id == 1){
            //ticket toegewezen
            $this->message->newMessage("Er is een ticket aan u toegewezen: " . $this->titel, WWW_ROOT . "index.php?page=tickets&subpage=toegewezentickets", $this->pers_id);
        }elseif($this->ticket_status_id == 2){
            //naar verholpen
            $this->message->newMessage("Ticket heeft goedkeuring nodig: " . $this->titel, $this->ticket_id);
        }elseif($this->ticket_status_id == 3){
            //naar afgerond
            
        }
        
        
        
        // set a message in the messageboard
    }

    /**
     * Set @var createdate to the current date and time
     */
    public function setCreatedate() {
        $this->createdate = DATE('Y-m-d H:i:s');
    }

    public function getTicketArray($sortBy, $orderBy) {
        return $this->db->getTicketArray($sortBy, $orderBy);
    }

    public function getAfdeling($afdelingid) {
        if($result = $this->afdeling->getAfdelingById($afdelingid)) {
            echo 'jaa het werkt';
            return $result;
        } else {
            echo 'het werkt niet';
        }
    }

    public function getObject($objectid) {
        return $this->object->getObjectById($objectid);
    }

    /**
     *  Setters
     * @param type $key
     * @param type $var
     */
    public function __set($key, $var) {
        $this->$key = $var;
    }

    /**
     * Getters
     * @param type $var
     * @return type
     */
    public function __get($var) {
        return $this->$var;
    }

}

?>
