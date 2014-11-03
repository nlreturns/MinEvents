<?php

/**
 *
 * @author Donny van Walsem
 * @version 2.0
 */
include_once FILE_DATABASE;

class DbTicket extends Database {

    /**
     * Private $var afdelingid
     */
    private $afdelingid;

    /**
     * Private $var objectid
     */
    private $objectid;
    private $db;

    /**
     *
     */
    private $array;

    /**
     * Function to create a ticket
     * 
     * @param type $titel
     * @param type $beschrijving
     * @param type $progress
     * @param type $createtijd
     */
    public function __construct() {
        $this->db = new Database;
    }

    public function createTicket($creator, $titel, $beschrijving, $progress, $createtijd) {
        /**
         * SQL to insert ticket into ticketsysteem
         */
        $sql = "INSERT INTO ticketsysteem (creator_id, ticket_titel, ticket_beschrijving, ticket_progress, ticket_create_tijd, afdeling_id, object_id)
        VALUES ('" . mysql_real_escape_string($creator) . "', '" . mysql_real_escape_string($titel) . "', '" . mysql_real_escape_string($beschrijving) . "', '" . mysql_real_escape_string($progress) . "', '" . mysql_real_escape_string($createtijd) . "', '" . mysql_real_escape_string($this->afdelingid) . "', '" . mysql_real_escape_string($this->objectid) . "')";
        /**
         * $var db execute query
         */
        $this->db->dbquery($sql);
    }

    /**
     * check the status_id
     * @param type $status_id
     * @return bool TRUE (Ok) | FALSE (Nok) 
     */
    private function checkStatusId($status_id) {
        if (!$this->checkId($status_id, FIELD_TICKET_STATUS_ID)) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * check the prio_id
     * @param type $prio_id
     * @return bool TRUE (Ok) | FALSE (Nok) 
     */
    private function checkPrioId($prio_id) {
        if (!$this->checkId($prio_id, FIELD_TICKET_PRIO_ID)) {
            return FALSE;
        } else {
            
        }
        return TRUE;
    }

    /**
     * check the title
     * @param type $title
     * @return bool TRUE (Ok) | FALSE (Nok) 
     */
    private function checkTitle($title) {
        if (empty($title)) {
            $this->setError(FIELD_TICKET_TITLE);
        } else if (!is_string($title)) {
            $this->setError(TXT_ERROR_WRONG_VAR_TYPE . FIELD_TICKET_TITLE);
        } else if (strlen($title) > LEN_TICKET_TITLE) {
            $this->setError(TXT_ERROR_VAR_SIZE . ' ' . FIELD_TICKET_TITLE);
            trigger_error(__FILE__ . ' ' . __LINE__ . ' Found errors ' . __FUNCTION__ . '<br/>');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Delete the ticket
     */
    public function deleteTicket($id) {
        if (!empty($id)) {
            // create query
            $query = "DELETE FROM `" . DB_NAME . "`.`" . TBL_TICKETSYSTEEM .
                    "` WHERE `" . TBL_TICKETSYSTEEM . "`.`" . FIELD_TICKET_ID . "` = '" . $id . "'";
            
            // execute query
            $result = $this->dbquery($query);

            return TRUE;
        }
    }

    /**
     * Update the description of a ticket entry <br />
     *
     * @return bool TRUE | FALSE (Lookup the error array)
     */
    public function updateTicket($titel, $pers_id, $afdeling, $object, $beschrijving, $progress, $prioid, $ticket_status_id, $ticket_end_tijd) {
        // check if not empty
        if (!empty($this->ticket_id)) {
            // check fields
            if ($this->checkStatusId($this->status_id, FIELD_TICKET_STATUS_ID) &&
                    $this->checkPrioId($this->prio_id, FIELD_TICKET_PRIO_ID)
            ) {

                // create query
                $query = "UPDATE `" . DB_NAME . "`.`" . TBL_TICKETSYSTEEM .
                        "` SET `" . FIELD_TICKET_STATUS_ID . "` = '" . $ticket_status_id . "',`" .
                        FIELD_TICKET_PRIO_ID . "` = '" . $prioid . "',`" .
                        FIELD_TICKET_TITLE . "` = '" . $titel . "',`" .
                        FIELD_TICKET_DESC . "` = '" . $beschrijving . "',`" .
                        FIELD_TICKET_PROGRESS . "` = '" . $progress . "',`" .
                        FIELD_PERS_ID . "` = '" . $pers_id . "', `" .
                        FIELD_AFDELING_ID . "` = '" . $afdeling . "', `" .
                        FIELD_OBJECT_ID . "` = '" . $object . "', `" .
                        FIELD_TICKET_PROGRESS . "` = '" . $progress . "', `" .
                        FIELD_TICKET_END_TIME . "` = '" . $ticket_end_tijd . "' 
                        WHERE `" . TBL_TICKETSYSTEEM . "`.`" . FIELD_TICKET_ID . "` = '" . $this->ticket_id . "'";

                // execute query
                $result = $this->dbquery($query);


                return TRUE;
            }
            return FALSE;
        } else {
            // set error
            $this->setError(TXT_NO_VALID_TICKET_ID);
        }
    }

    /**
     *
     * Load ticket with $ticket_id from database.<br />
     *
     * @param int $ticket_id Ticket id.
     * @return bool TRUE if class data is filled or
     *              FALSE if error found (Check error array)
     */
    public function getDbTicket($ticket_id = '') {

        if (empty($ticket_id) && !empty($this->ticket_id)) {
            $ticket_id = $this->ticket_id;
        } else if (!empty($ticket_id) && !empty($this->ticket_id)) {
            /* Reset this class firsth */
            $this->reset();
        } else if (empty($ticket_id) && empty($this->ticket_id)) {
            /* Both empty -> Error */
            $this->setError(TXT_ERROR . TXT_NO_VALID_TICKET_ID);
            return FALSE;
        } else {
            /* Use $ticket_id */
        }

        if (!$this->checkTicketId($ticket_id, FIELD_TICKET_ID)) {
            return FALSE;
        }
        $query = "SELECT *
                FROM `ticketsysteem`
                LEFT JOIN `afdeling` ON `ticketsysteem`.`afdeling_id` = `afdeling`.`afdeling_id` 
                LEFT JOIN `object` ON `ticketsysteem`.`object_id` = `object`.`object_id` 
                LEFT JOIN `gebruiker` ON `ticketsysteem`.`pers_id` = `gebruiker`.`gebruiker_id` 
                WHERE `ticketsysteem`.`ticket_id` = '" . $ticket_id . "'";
        
        /*
         * "SELECT ticketsysteem.ticket_titel, ticketsysteem.ticket_beschrijving, ticketsysteem.ticket_progress, ticketsysteem.ticket_create_tijd, ticketsysteem.ticket_end_tijd, afdeling.afdeling_naam, object.objectnaam, gebruiker.gebruiker_naam
           FROM ticketsysteem
           FULL OUTER JOIN afdeling ON ticketsysteem.afdeling_id = afdeling.afdeling_id
           FULL OUTER JOIN object ON ticketsysteem.object_id = object.object_id
           FULL OUTER JOIN gebruiker ON ticketsysteem.pers_id = gebruiker.gebruiker_id
           WHERE ticketsysteem.ticket_id = '" . $ticket_id . "'";
         * 
         * SELECT Customers.CustomerName, Orders.OrderID
            FROM Customers
            FULL OUTER JOIN Orders
            ON Customers.CustomerID=Orders.CustomerID
            ORDER BY Customers.CustomerName;
         */
        
        $query = $this->dbquery($query);
        $ticket_array = $this->dbFetchArray($query);
        if ($ticket_array !== FALSE) {

            /* Save class data */
            $this->ticket_id = $ticket_id;
            $this->status_id = $ticket_array[FIELD_TICKET_STATUS_ID];
            $this->pers_id = $ticket_array[FIELD_PERS_ID];
            $this->prio_id = $ticket_array[FIELD_TICKET_PRIO_ID];
            $this->ticket_titel = $ticket_array[FIELD_TICKET_TITLE];
            $this->ticket_beschrijving = $ticket_array[FIELD_TICKET_DESC];
            $this->ticket_progress = $ticket_array[FIELD_TICKET_PROGRESS];
            $this->ticket_create = $ticket_array[FIELD_TICKET_CREATE_TIME];
            $this->ticket_end = $ticket_array[FIELD_TICKET_END_TIME];
            $this->afdeling_id = $ticket_array[FIELD_AFDELING_ID];
            $this->object_id = $ticket_array[FIELD_OBJECT_ID];

            return $ticket_array;
        }
        return FALSE;
    }

    /**
     *
     * Load ticket with $ticket_id from database.<br />
     *
     * @param int $ticket_id Ticket id.
     * @return bool TRUE if class data is filled or
     *              FALSE if error found (Check error array)
     */
    public function getDbTicketByID($ticket_id = '') {

        if (empty($ticket_id) && !empty($this->ticket_id)) {
            $ticket_id = $this->ticket_id;
        } else if (!empty($ticket_id) && !empty($this->ticket_id)) {
            /* Reset this class firsth */
            $this->reset();
        } else if (empty($ticket_id) && empty($this->ticket_id)) {
            /* Both empty -> Error */
            $this->setError(TXT_ERROR . TXT_NO_VALID_TICKET_ID);
            return FALSE;
        } else {
            /* Use $ticket_id */
        }

        if (!$this->checkTicketId($ticket_id, FIELD_TICKET_ID)) {
            return FALSE;
        }

        $query = "SELECT * FROM `" . TBL_TICKETSYSTEEM . "`" .
                " WHERE `" . FIELD_TICKET_ID . "` = '" . $ticket_id . "'";

        $query = $this->dbquery($query);
        $ticket_array = $this->dbFetchArray($query);
        if ($ticket_array !== FALSE) {

            /* Save class data */
            $this->ticket_id = $ticket_id;
            $this->status_id = $ticket_array[FIELD_TICKET_STATUS_ID];
            $this->pers_id = $ticket_array[FIELD_PERS_ID];
            $this->prio_id = $ticket_array[FIELD_TICKET_PRIO_ID];
            $this->ticket_titel = $ticket_array[FIELD_TICKET_TITLE];
            $this->ticket_beschrijving = $ticket_array[FIELD_TICKET_DESC];
            $this->ticket_progress = $ticket_array[FIELD_TICKET_PROGRESS];
            $this->ticket_create = $ticket_array[FIELD_TICKET_CREATE_TIME];
            $this->ticket_end = $ticket_array[FIELD_TICKET_END_TIME];
            $this->afdeling_id = $ticket_array[FIELD_AFDELING_ID];
            $this->object_id = $ticket_array[FIELD_OBJECT_ID];

            return $ticket_array;
        }
        return FALSE;
    }

    /*
     * Check the provided id 
     * @param int $ticket_id A ticket Id
     * @return bool TRUE (Ok) | FALSE (Nok)
     */

    private function checkTicketId($ticket_id) {
        if (!$this->checkId($ticket_id, FIELD_TICKET_ID)) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Set afdelingid
     * @param type $afdeling
     */
    public function setAfdelingId($afdeling) {
        $this->afdelingid = $afdeling;
    }

    /**
     * 
     * set objectid
     * @param type $object
     */
    public function setObjectId($object) {
        $this->objectid = $object;
    }

    public function getTicketArray($sortBy, $orderBy) {

        $query = "SELECT * FROM (
                    SELECT * FROM ticketsysteem LIMIT 0, 100
                    ) sub ORDER BY $sortBy $orderBy ";
        
        // fetches the array using Database's fetchDbArray function.
        // If it's null,
        if (!$this->dbquery($query)) {
            return false;
        }
        if (!($result = $this->dbFetchAll())) {
            // set error.
            echo TXT_NO_DATA;
            return FALSE;
        }
        return $result;
    }

    public function getPriority($prioid) {
        if (!$prioid) {
            $priolabel = 'Niet ingevuld';
        } else {
            $sql = "SELECT * FROM ticket_prio WHERE ticket_prio_id = '$prioid'";
            $result = $this->db->dbquery($sql);
            while ($row = mysql_fetch_assoc($result)) {
                $priolabel = $row['ticket_prio_label'];
            }
        }
        return $priolabel;
    }

    public function getObject($objectid) {
        $sql = "SELECT * FROM object WHERE object_id = '$objectid'";
        $result = $this->db->dbquery($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $objectid = $row['object_naam'];
        }
        return $objectid;
    }

    public function getAfdeling($afdelingid) {
        $sql = "SELECT * FROM afdeling WHERE afdeling_id = '$afdelingid'";
        $result = $this->db->dbquery($sql);
        while ($row = mysql_fetch_assoc($result)) {
            $afdelingid = $row['afdeling_naam'];
        }
        return $afdelingid;
    }

}

?>