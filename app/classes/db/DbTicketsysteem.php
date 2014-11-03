<?php
namespace minevents\app\classes\db;

/**
 * Description of db_ticketsysteem
 * 
 *
 * @author JDuysserinck
 * @version 0.5
 *
 * Version History :
 * 0.1  Initial version.
 * 0.2  Added prioriteit ticketsysteem
 * 0.3 Added location ticketsysteem
 * 0.4 Added status ticketsysteem
 * 0.5 Finished save, select, update and delete functions
 */
class DbTicketsysteem extends Database {

    private $ticket_id;
    private $status_id;
    private $prio_id;
    private $loc_id;
    private $title;
    private $desc;
    private $prog;
    private $createtime;
    private $endtime;

    public function DbTicketsysteem($ticket_id = '') {
        parent::__construct();

        if (empty($ticket_id)) {
            /* Check whether the database already is created */
            if (!$this->dbTableExists(TBL_TICKETSYSTEEM)) {
                $this->createTable();
            }


            if (!$this->dbTableExists(TBL_TICKETPRIO)) {
                $msg_type = new DbTicketsysteemPrio();
                unset($msg_type);
            }

            if (!$this->dbTableExists(TBL_TICKETLOC)) {
                $msg_type = new DbTicketsysteemLoc();
                unset($msg_type);
            }
        } else if ($this->getDbTicket($ticket_id) === FALSE) {
            /** Update class with db info * */
            return FALSE;
        }
    }

    public function save($status_id, $prio_id, $loc_id, $title, $desc, $prog, $endtime, $afdeling) {



        if ($this->checkLocId($loc_id) &&
                $this->checkTitle($title) &&
                $this->checkProg($prog) &&
                $this->checkEndtime($endtime)) {
            /* Insert with values */
            $query = "INSERT INTO `" . TBL_TICKETSYSTEEM .
                    "`(`" . FIELD_TICKET_PRIO_ID . "`,`" .
                    FIELD_TICKET_LOC_ID . "`,`" .
                    FIELD_TICKET_TITLE . "`,`" .
                    FIELD_TICKET_DESC . "`,`" .
                    FIELD_TICKET_PROGRESS . "`,`" .
                    FIELD_TICKET_END_TIME . "`)" .
                    " VALUES ('" . $this->dbInString($prio_id) . "','" .
                    $this->dbInString($loc_id) . "','" .
                    $this->dbInString($title) . "','" .
                    $this->dbInString($desc) . "','" .
                    $this->dbInString($prog) . "','" .
                    $this->dbInString($endtime) . "')";

            $this->dbquery($query);
            if ($this->checkDbErrors($query)) {
                return FALSE;
            }


            /* Update class attributes */
            $this->ticket_id = mysql_insert_id($this->connection);
            $this->status_id = $status_id;
            $this->prio_id = $prio_id;
            $this->loc_id = $loc_id;
            $this->title = $title;
            $this->desc = $desc;
            $this->prog = $prog;
            $this->createtime = $this->getCreateTime();
            $this->endtime = $endtime;
        } else {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * get ticket_id
     * @param private ticket_id 
     */
    public function getTicketId() {
        return $this->ticket_id;
    }

    /**
     * get status_id
     * @param private status_id 
     */
    public function getStatusId() {
        return $this->status_id;
    }

    /**
     * get pers_id
     * @param private pers_id 
     */
    public function getPersId() {
        return $this->pers_id;
    }

    /**
     * get loc_id
     * @param private loc_id 
     */
    public function getLocId() {
        return $this->loc_id;
    }

    /**
     * get prio_id
     * @param private prio_id 
     */
    public function getPrioId() {
        return $this->prio_id;
    }

    /**
     * get titel
     * @param private ticket_titel 
     */
    public function getTicketTitel() {
        return $this->ticket_titel;
    }

    /**
     * get description
     * @param private ticket_beschrijving
     */
    public function getTicketBeschrijving() {
        return $this->ticket_beschrijving;
    }

    /**
     * get progress
     * @param private ticket_progress
     */
    public function getTicketProgress() {
        return $this->ticket_progress;
    }

    /**
     * get create time
     * @param private ticket_create 
     */
    public function getTicketCreate() {
        return $this->ticket_create;
    }

    /**
     * get ticket end
     * @param private ticket_end
     */
    public function getTicketEnd() {
        return $this->ticket_end;
    }

    /*
     *
     * @param int $ticket_id Id that is checked in the DB
     * @return bool TRUE if exists | FALSE
     */

    public function ticketIdExists($ticket_id) {
        if (!$this->checkId($ticket_id, FIELD_TICKET_ID)) {
            return FALSE;
        }

        $query = "SELECT `" . FIELD_TICKET_ID . "` FROM `" . TBL_TICKETSYSTEEM .
                "` WHERE `" . FIELD_TICKET_ID . "`='" . $id . "'";
        $result = $this->dbquery($query);


        if (!$this->checkDbErrors($query)) {

            return FALSE;
        }
        return TRUE;
    }

    /**
     *
     * Update the description of a ticket entry <br />
     *
     * @return bool TRUE | FALSE (Lookup the error array)
     */
    public function updateTicket($status_id, $prio_id, $loc_id, $title, $desc, $prog) {
        if (!empty($this->ticket_id)) {

            if ($this->checkStatusId($this->status_id, FIELD_TICKET_STATUS_ID) &&
                    $this->checkPrioId($this->prio_id, FIELD_TICKET_PRIO_ID) &&
                    $this->checkLocId($this->loc_id, FIELD_TICKET_LOC_ID) &&
                    $this->checkTitle($this->title, FIELD_TICKET_TITLE)
            ) {




                $query = "UPDATE `" . DB_NAME . "`.`" . TBL_TICKETSYSTEEM .
                        "` SET `" . FIELD_TICKET_STATUS_ID . "` = '" . $this->dbInString($status_id) . "',`" .
                        FIELD_TICKET_LOC_ID . "` = '" . $this->dbInString($loc_id) . "',`" .
                        FIELD_TICKET_PRIO_ID . "` = '" . $this->dbInString($prio_id) . "',`" .
                        FIELD_TICKET_TITLE . "` = '" . $this->dbInString($title) . "',`" .
                        FIELD_TICKET_DESC . "` = '" . $this->dbInString($desc) . "',`" .
                        FIELD_TICKET_PROGRESS . "` = '" . $prog .
                        "' WHERE `" . TBL_TICKETSYSTEEM . "`.`" . FIELD_TICKET_ID . "` =" . $this->ticket_id . "";
                $result = $this->dbquery($query);


                return ($this->checkError($query));
            }
            return FALSE;
        } else {
            $this->setError(TXT_NO_VALID_TICKET_ID);
        }
    }

    // function to delete an ticket entry
    public function delete() {
        if (!empty($this->ticket_id)) {
            if
            ($this->checkTicketId($this->ticket_id, FIELD_TICKET_ID)) {
                $query = "DELETE FROM " . TBL_TICKETSYSTEEM . " 
            WHERE `" . FIELD_TICKET_ID . "`='" . $this->ticket_id . "'";
                $result = $this->dbquery($query);
                return ($this->checkDbErrors($query));
            }
            return FALSE;
        } else {
            $this->setError(TXT_TICKET_DELETE);
        }
    }

    /**
     *
     * @return Timestamp | empty string ('')
     */
    private function getCreatetime() {

        $query = "SELECT `" . FIELD_TICKET_CREATE_TIME . "` FROM `" . TBL_TICKETSYSTEEM .
                "` WHERE `" . FIELD_TICKET_ID . "`='" . $this->ticket_id . "'";
        $result = $this->dbquery($query);

        if (!$this->checkDbErrors($query)) {

            $row_array = $this->dbFetchArray();
            return $row_array[FIELD_TICKET_CREATE_TIME];
        }
        return '';
    }

    /**
     *
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
     * check the loc_id
     * @param type $loc_id
     * @return bool TRUE (Ok) | FALSE (Nok) 
     */
    private function checkLocId($loc_id) {
        if (!$this->checkId($loc_id, FIELD_TICKET_LOC_ID)) {
            return FALSE;
        } else {
            
        }
        return TRUE;
    }

    /**
     * check the progress
     * @param type $prog
     * @return bool TRUE (Ok) | FALSE (Nok) 
     */
    private function checkProg($prog) {
        if (empty($prog) ||
                (!is_string($prog)) ||
                (strlen($prog) > LEN_TICKET_PROGRESS)) {

            $this->setError(TXT_ERROR_EMPTY);
            trigger_error(__FILE__ . ' ' . __LINE__ . ' Found errors in [' . $prog . '] ' . __FUNCTION__ . '<br/>');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * check the end time
     * @param type $endtime
     * @return bool TRUE (Ok) | FALSE (Nok) 
     */
    private function checkEndtime($endtime) {
        if (empty($endtime)) {
            return FALSE;
        } else {
            
        }
        return TRUE;
    }

    /**
     *
     * Check the person Id
     * 
     * @param int $pers_id of a person.
     * @param string $pers_id
     * @return bool TRUE (Ok) | FALSE (Nok)
     */
    private function checkPersId($id, $field) {
        if (!$this->checkId($id, $field)) {
            return FALSE;
        } else {
            
        }
        return TRUE;
    }

    /**
     * check the description
     * @param type $desc
     * @return bool TRUE (Ok) | FALSE (Nok) 
     */
    private function checkDesc($desc) {
        if (empty($desc) ||
                (!is_string($desc)) ||
                (strlen($desc) > LEN_TICKET_DESC)) {

            $this->setError(TXT_ERROR_EMPTY);
            trigger_error(__FILE__ . ' ' . __LINE__ . ' Found errors in [' . $desc . '] ' . __FUNCTION__ . '<br/>');
            return FALSE;
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
            setError(TXT_ERROR . TXT_NO_VALID_TICKET_ID);
            return FALSE;
        } else {
            /* Use $ticket_id */
        }

        if (!$this->checkTicketId($ticket_id, FIELD_TICKET_ID)) {
            return FALSE;
        }
        $query = "SELECT `" . FIELD_TICKET_ID . "`,`" .
                FIELD_TICKET_STATUS_ID . "`,`" .
                FIELD_PERS_ID . "`,`" .
                FIELD_TICKET_PRIO_ID . "`,`" .
                FIELD_TICKET_LOC_ID . "`,`" .
                FIELD_TICKET_TITLE . "`,`" .
                FIELD_TICKET_DESC . "`,`" .
                FIELD_TICKET_PROGRESS . "`,`" .
                FIELD_TICKET_CREATE_TIME . "`,`" .
                FIELD_TICKET_END_TIME . "`" .
                " FROM `" . TBL_TICKETSYSTEEM . "`" .
                " WHERE `" . FIELD_TICKET_ID . "` = '" . $ticket_id . "'";
        $this->dbquery($query);
        if ($this->checkDbErrors($query)) {
            return FALSE;
        }
        $ticket_array = $this->dbFetchArray();

        if ($ticket_array !== FALSE) {

            /* Save class data */
            $this->ticket_id = $ticket_id;
            $this->status_id = $ticket_array[FIELD_TICKET_STATUS_ID];
            $this->pers_id = $ticket_array[FIELD_PERS_ID];
            $this->prio_id = $ticket_array[FIELD_TICKET_PRIO_ID];
            $this->loc_id = $ticket_array[FIELD_TICKET_LOC_ID];
            $this->ticket_titel = $ticket_array[FIELD_TICKET_TITLE];
            $this->ticket_beschrijving = $ticket_array[FIELD_TICKET_DESC];
            $this->ticket_progress = $ticket_array[FIELD_TICKET_PROGRESS];
            $this->ticket_create = $ticket_array[FIELD_TICKET_CREATE_TIME];
            $this->ticket_end = $ticket_array[FIELD_TICKET_END_TIME];

            return TRUE;
        }
        return FALSE;
    }

    private function createTable() {

        /* Table Ticketsysteem */
        $q = "CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`" . TBL_TICKETSYSTEEM . "` (" .
                "`" . FIELD_TICKET_ID . "` bigint(10) NOT NULL AUTO_INCREMENT," .
                "`" . FIELD_PERS_ID . "` bigint(10) NOT NULL," .
                "`" . FIELD_TICKET_STATUS_ID . "` bigint(10) NOT NULL," .
                "`" . FIELD_TICKET_LOC_ID . "` bigint(10) NOT NULL," .
                "`" . FIELD_TICKET_PRIO_ID . "` bigint(10) NOT NULL," .
                "`" . FIELD_TICKET_TITLE . "` varchar(" . LEN_TICKET_TITLE . ") collate latin1_general_cs NOT NULL," .
                "`" . FIELD_TICKET_DESC . "` varchar(" . LEN_TICKET_DESC . ") collate latin1_general_cs NOT NULL," .
                "`" . FIELD_TICKET_PROGRESS . "` varchar(" . LEN_TICKET_PROGRESS . ") collate latin1_general_cs NOT NULL," .
                "`" . FIELD_TICKET_CREATE_TIME . "` timestamp NOT NULL default CURRENT_TIMESTAMP," .
                "`" . FIELD_TICKET_END_TIME . "` timestamp NOT NULL," .
                "PRIMARY KEY  (`" . FIELD_TICKET_ID . "`)," .
                "KEY `idx_" . FIELD_TICKET_STATUS_ID . "` (`" . FIELD_TICKET_STATUS_ID . "`)," .
                "KEY `idx_" . FIELD_TICKET_PRIO_ID . "` (`" . FIELD_TICKET_PRIO_ID . "`)" .
                ") ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs";

        if (!$this->dbquery($q)) {
            $this->checkDbErrors($q);
            trigger_error(__FILE__ . ' ' . __LINE__ . ' Found errors ' . __FUNC__ . '<br/>');
            return FALSE;
        }
    }

}

class TestDbTicketsysteem {

    public function TestDbTicketsysteem() {

        echo "Test save functie<br />";
        $test = new DbTicketsysteem();

        $test->save(1, 1, 1, 'dit is de beschrijving', 'linkto?id=1234543', 1, 1, 1);


        echo "<pre>";
        var_dump($test);
        echo "</pre>";

        echo "Test 1 aanpas<br />";
        $test1 = new DbTicketsysteem(248);
        $test1->updateTicket(0, 0, 0, 'titel', 'desc', 'prog') . "<BR>";

        echo "Test 2 select functie<br />";
        $test2 = new DbTicketsysteem(248);


        echo "ID: " . $test2->getTicketId() . "<BR>";
        echo "STATUS ID " . $test2->getStatusId() . "<BR>";
        echo "PERSOON ID: " . $test2->getPersId() . "<BR>";
        echo "LOC ID: " . $test2->getLocId() . "<BR>";
        echo "PRIO ID: " . $test2->getPrioId() . "<BR>";
        echo "TICKET TITEL: " . $test2->getTicketTitel() . "<BR>";
        echo "TICKET BESCHRIJVING: " . $test2->getTicketBeschrijving() . "<BR>";
        echo "TICKET VOORTGANG: " . $test2->getTicketProgress() . "<BR>";
        echo "TICKET CREATE TIJD: " . $test2->getTicketCreate() . "<BR>";
        echo "TICKET END TIJD: " . $test2->getTicketEnd() . "<BR>";

        echo "<pre>";
        var_dump($test2);
        echo "</pre>";


        echo "Test 3 status db test.<br />";
        $test3 = new DbTicketsysteemStatus();

        echo "<pre>";
        var_dump($test3);
        echo "</pre>";

        echo "Test 4 prio db test.<br />";
        $test4 = new DbTicketsysteemPrio();

        echo "<pre>";
        var_dump($test4);
        echo "</pre>";

        echo "Test 5 loc db test.<br />";
        $test5 = new DbTicketsysteemLoc();

        echo "<pre>";
        var_dump($test5);
        echo "</pre>";

        echo "Test 6 delete functie.<br />";
        $test6 = new DbTicketsysteem(252);
        $test6->delete();
    }

}

?>          