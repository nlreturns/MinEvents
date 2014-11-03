<?php

namespace minevents\app\classes\db;

/**
 * Description of db_messageboard
 * 
 *
 * @author GHoogendoorn
 * @version 0.2
 *
 * Version History :
 * 0.1  Initial version.
 * 0.2  Added Message prio/ Change history support
 */
class DbMessageBoard extends Database {

    private $id;
    private $status_id;
    private $prio_level;
    private $title;
    private $desc;
    private $link;
    private $type_id;
    private $from;
    private $to;
    private $deadline;
    private $createtime;
    private $orig_create_id;
    private $orig_create_type_id;

    public function DbMessageBoard($id = '') {
        parent::__construct();

        if (empty($id)) {
            /* Check whether the database already is created */
            if (!$this->dbTableExists(TBL_MESSAGEBOARD)) {
                $this->createTable();
            }
            if (!$this->dbTableExists(TBL_MESSAGETYPE)) {
                /* Create by calling constructor */
                $msg_type = new DbMessageboardType();
                unset($msg_type);
            }
            if (!$this->dbTableExists(TBL_MESSAGESTATUS)) {
                /* Create by calling constructor */
                $msg_type = new DbMessageboardStatus();
                unset($msg_type);
            }
            if (!$this->dbTableExists(TBL_MESSAGE_PRIO)) {
                $msg_type = new DbMessageboardPrio();
                unset($msg_type);
            }
            if (!$this->dbTableExists(TBL_MESSAGE_CHANGE_HISTORY)) {
                $msg_type = new DbMessageChangeHistory();
                unset($msg_type);
            }
        } else if ($this->getDbMsg($id) === FALSE) {
            /** Update class with db info * */
            return FALSE;
        }
    }

    public function save($desc, $link, $to = null) {

        if (
                $this->checkDesc($desc) &&
                $this->checkLink($link)) {

            $query = "INSERT INTO `" . TBL_MESSAGEBOARD .
                    "`(`" . FIELD_MSGBRD_DESC . "`,`" .
                    FIELD_MSGBRD_TO . "`,`" .
                    FIELD_MSGBRD_LINK . "`)
                    VALUES ('" . $this->dbInString($desc) . "','" .
                    $to . "','" .
                    $this->dbInString($link) . "')";

            $this->dbquery($query);

            if ($this->checkDbErrors($query)) {
                return FALSE;
            }

            /* Update class attributes */
            $this->id = mysql_insert_id($this->connection);
            $this->desc = $desc;
            $this->link = $link;
            $this->to = $to;
            $this->createtime = $this->getCreateTime();
        } else {
            return FALSE;
        }
        return TRUE;
    }

    public function getMessageListForUser($id, $limit, $start) {

        if ((!is_numeric($limit) ) ||
                (!is_numeric($start) )
        ) {
            return FALSE;
        }

        $query = "SELECT * FROM (
                 SELECT * FROM `" . TBL_MESSAGEBOARD . "`" .
                " WHERE `" . FIELD_MSGBRD_TO . "` = '" . $id . "' LIMIT " . $start .",". $limit
                . ") sub ORDER BY " . FIELD_MSGBRD_TO . " ASC";
        
        $this->dbquery($query);

        if ($this->checkDbErrors($query)) {
            return FALSE;
        }

        /** Fetch all entries * */
        $msg_array = $this->dbFetchAll();


        return $msg_array;
    }

    public function getMessageId() {
        if (!empty($this->id)) {
            return $this->id;
        }
        return FALSE;
    }

    /**
     *
     * Collect class data and return.<br />
     * When a different or new id is provided the class vars
     * are loaded from the database.
     *
     * @return bool  FALSE If no valid msg_id was found
     * @return array class data_array.
     */
    public function getMessage($id = '') {
        if (empty($id) && empty($this->id)) {
            /* Both empty is error */
            $this->setError(TXT_ERROR . TXT_NO_VALID_MSG_ID);
            return FALSE;
        } else if (!empty($id) && empty($this->id)) {
            /* New id load */
            $this->getDbMsg($id);
        } if (!empty($id) && !empty($this->id) && ($id != $this->id)) {
            /* Different Id reload */
            $this->getDbMsg($id);
        } else {
            /* Valid class id */
        }

        if (!$this->checkMsgId($this->id)) {
            /* Finaly still no valid msg id */
            return FALSE;
        }
        $return_array = array();
        $return_array['id'] = $this->id;
        $return_array['status_id'] = $this->status_id;
        $return_array['prio_level'] = $this->prio_level;
        $return_array['title'] = $this->title;
        $return_array['desc'] = $this->desc;
        $return_array['link'] = $this->link;
        $return_array['type_id'] = $this->type_id;
        $return_array['from'] = $this->from;
        $return_array['to'] = $this->to;
        $return_array['deadline'] = $this->deadline;
        $return_array['createtime'] = $this->createtime;

        return $return_array;
    }

    /**
     * The firsth status is always new,
     * but the Id does change.
     * Hence this function...
     * @return bool FALSE | int Id from the new status
     */
    public function getNewStatusId() {
        $db_status = new DbMessageboardStatus();
        return $db_status->getNewStatusId();
    }

    public function getMessageType($type) {

        switch ($type) {
            case MSG_TYPE_MODULE:
                $msg_type_txt = 'TXT_MSG_TYPE_MODULE';
                break;
            case MSG_TYPE_PERSON:
                $msg_type_txt = 'TXT_MSG_TYPE_PERS';
                break;
            default:
                /* Unknown type */
                return FALSE;
        }

        $query = "SELECT `" . FIELD_MSG_TYPE_ID . "` FROM `" . TBL_MESSAGETYPE .
                "` WHERE `" . FIELD_MSG_TYPE_NAME . "`='" . $msg_type_txt . "'";

        $result = $this->dbquery($query);
        if (!$this->checkDbErrors($query)) {
            $id = $this->dbFetchArray();

            /* Return only id */
            return $id[FIELD_MSG_TYPE_ID];
        } else {
            $this->setError($this->getDbError());
        }
        return FALSE;
    }

    /**
     *
     * @param int $id Id that is checked in the DB
     * @return bool TRUE if exists | FALSE
     */
    public function msgIdExists($id) {
        if (!$this->checkId($id, FIELD_MSGBRD_ID)) {
            return FALSE;
        }

        $query = "SELECT `" . FIELD_MSGBRD_ID . "` FROM `" . TBL_MESSAGEBOARD .
                "` WHERE `" . FIELD_MSGBRD_ID . "`='" . $id . "'";
        $result = $this->dbquery($query);

//echo __FILE__. __LINE__ . $query;

        if (!$this->checkDbErrors($query)) {

            return FALSE;
        }
        return TRUE;
    }

    /**
     *
     * Update the description of a messageboard entry (message)<br />
     *
     * @param string $desc New description of the message
     * @return bool TRUE | FALSE (Lookup the error array)
     */
    public function updateMessageDesc($desc) {

        if ($this->checkDesc($desc) &&
                $this->checkId($this->id, FIELD_MSGBRD_ID)) {

            $query = "UPDATE `" . DB_NAME . "`.`" . TBL_MESSAGEBOARD .
                    "` SET `" . FIELD_MSGBRD_DESC . "` = '" . $this->dbInString($desc) .
                    "' WHERE `" . TBL_MESSAGEBOARD . "`.`" . FIELD_MSGBRD_ID . "` ='" . $this->id . "'";
            $result = $this->dbquery($query);

            return ($this->checkDbErrors($query));
        }
        return FALSE;
    }

    public function updateMessageStatus($new_status) {
        $db_status = new DbMessageboardStatus();

        $new_status_id = $db_status->getIdByName($new_status);

        if ($new_status_id === FALSE) {
            $this->setError(__FUNCTION__ . "() Error retrieving ID from Status: $new_status");
            return FALSE;
        }


        if ($this->checkStatusId($new_status_id) &&
                $this->checkId($this->id, FIELD_MSGBRD_ID)) {

            $query = "UPDATE `" . DB_NAME . "`.`" . TBL_MESSAGEBOARD .
                    "` SET `" . FIELD_MSG_STATUS_ID . "` = '" . $new_status_id .
                    "' WHERE `" . TBL_MESSAGEBOARD . "`.`" . FIELD_MSGBRD_ID . "` ='" . $this->id . "'";

            $result = $this->dbquery($query);

            return ($this->checkDbErrors($query));
        }
        return FALSE;
    }

    /**
     * updateToId will update te message originator
     * it also updates the from id with the curren to id.
     *
     * @param <type> $to
     */
    public function forwardMessage($to) {
        
    }

    /**
     *
     * @return Timestamp | empty string ('')
     */
    private function getCreateTime() {

        $query = "SELECT `" . FIELD_MSGBRD_CREATE_TIME . "` FROM `" . TBL_MESSAGEBOARD .
                "` WHERE `" . FIELD_MSGBRD_ID . "`='" . $this->id . "'";
        $result = $this->dbquery($query);

        if (!$this->checkDbErrors($query)) {

            $row_array = $this->dbFetchArray($result);
            return $row_array[FIELD_MSGBRD_CREATE_TIME];
        }
        return '';
    }

    /**
     *
     * Check the provided id 
     * @param int $id A message Id
     * @return bool TRUE (Ok) | FALSE (Nok)
     */
    private function checkMsgId($id) {
        if (!$this->checkId($id, FIELD_MSGBRD_ID)) {
            return FALSE;
        }
        return TRUE;
    }

    private function checkStatusId($id) {
        if (!$this->checkId($id, FIELD_MSG_STATUS_ID)) {
            return FALSE;
        }
        return TRUE;
    }

    private function checkTypeId($id) {
        if (!$this->checkId($id, FIELD_MSG_TYPE_ID)) {
            return FALSE;
        } else {
            // Look up in type table for existance
        }
        return TRUE;
    }

    /**
     *
     * @param int $id   Id of the originating module or person
     * @param int $type Type determing the originator is a module or person.
     * @return TRUE or FALSE (Check the error array)
     */
    private function checkFromId($id, $type) {
        if (!$this->checkId($id, FIELD_MSGBRD_FROM)) {
            return FALSE;
        } else {

            $db_msg_type = new DbMessageboardType();
            $msg_type_name = $db_msg_type->getNameById($id);

            switch ($msg_type_name) {
                case MSG_TYPE_PERSON:
                    // Look up in type pers id for existance
                    break;
                case MSG_TYPE_MODULE:
                    // lookup in module table
                    break;
                default:
                    $this->setError(TXT_ERROR_ID_NOT_EXISTS . ' ' . FIELD_MSGBRD_FROM);
                    trigger_error(__FILE__ . ' ' . __LINE__ . ' Found errors ' . __FUNCTION__ . '<br/>');
                    return FALSE;
            }
        }
        return TRUE;
    }

    /**
     *
     * Check the a person Id
     * 
     * @param int $id Id of a person.
     * @param string $field Name of database field
     * @return bool TRUE (Ok) | FALSE (Nok)
     */
    private function checkPersId($id, $field) {
        if (!$this->checkId($id, $field)) {
            return FALSE;
        } else {
            // Look up in type pers id for existance
        }
        return TRUE;
    }

    /**
     *  @todo Make it work
     * @param <type> $lvl
     * @return <type>
     */
    private function checkLevel($lvl) {
        return TRUE;
        if (empty($lvl)) {
            $this->setError(TXT_ERROR_EMPTY . FIELD_MSG_PRIO_LEVEL);
            trigger_error(__FILE__ . ' ' . __LINE__ . ' Found errors ' . __FUNCTION__ . '<br/>');
            return FALSE;
        } else {
            // look up in prio table for existance
        }
        return TRUE;
    }

    private function checkDesc($text) {
        if (empty($text) ||
                (!is_string($text)) ||
                (strlen($text) > LEN_MSGBRD_DESC)) {

            $this->setError(TXT_ERROR_EMPTY . FIELD_MSG_PRIO_LEVEL);
            trigger_error(__FILE__ . ' ' . __LINE__ . ' Found errors in [' . $text . '] ' . __FUNCTION__ . '<br/>');
            return FALSE;
        }
        return TRUE;
    }

    private function checkTitle($title) {
        if (empty($title)) {
            $this->setError(TXT_ERROR . FIELD_MSGBRD_TITLE);
        } else if (!is_string($title)) {
            $this->setError(TXT_ERROR_WRONG_VAR_TYPE . FIELD_MSGBRD_TITLE);
        } else if (strlen($title) > LEN_MSGBRD_TITLE) {
            $this->setError(TXT_ERROR_VAR_SIZE . ' ' . FIELD_MSGBRD_TITLE);
            trigger_error(__FILE__ . ' ' . __LINE__ . ' Found errors ' . __FUNCTION__ . '<br/>');
            return FALSE;
        }
        return TRUE;
    }

    private function checkLink($link) {
        if (strlen($link) > LEN_MSGBRD_LINK) {
            $this->setError(TXT_ERROR_VAR_SIZE . ' ' . FIELD_MSGBRD_LINK);
            return FALSE;
        }
        return TRUE;
    }

    /** @todo check time is in future... */
    private function checkDeadLine($time) {
        /* For now no meaningfull checks */
        return TRUE;
    }

    /**
     *  Class Messageboard reset:<br />
     *      Reset Error mechanism<br />
     *      Reset Db query results (Not the curren link)<br />
     *      Reset Class attributes<br />
     */
    private function reset() {
        /* Reset Error mechanism */
        $this->resetError();

        /* Reset Database */
        $this->dbReset();

        /* Reset Class attr */
        $this->id = '';
        $this->status_id = 0;
        $this->prio_level = 0;
        $this->title = '';
        $this->desc = '';
        $this->link = '';
        $this->type_id = 0;
        $this->from = 0;
        $this->to = 0;
        $this->deadline = '';
        $this->orig_create_id = '';
        $this->orig_create_type_id = '';
        $this->createtime = '';
    }

    /**
     *
     * Load msg with $id from database.<br />
     *  When a different id is provided, the class is reset
     *  and loaded with the new id.
     *
     * @param int $id Message id.
     * @return bool TRUE if class data is filled or
     *              FALSE if error found (Check error array)
     */
    private function getDbMsg($id = '') {

        if (empty($id) && !empty($this->id)) {
            $id = $this->id;
        } else if (!empty($id) && !empty($this->id)) {
            /* Reset this class firsth */
            $this->reset();
        } else if (empty($id) && empty($this->id)) {
            /* Both empty -> Error */
            setError(TXT_ERROR . TXT_NO_VALID_MSG_ID);
            return FALSE;
        } else {
            /* Use $id */
        }

        if (!$this->checkId($id, FIELD_MSGBRD_ID)) {
            return FALSE;
        }
        $query = "SELECT `" . FIELD_MSGBRD_ID . "`,`" .
                FIELD_MSG_STATUS_ID . "`,`" .
                FIELD_MSG_PRIO_LEVEL . "`,`" .
                FIELD_MSGBRD_TITLE . "`,`" .
                FIELD_MSGBRD_DESC . "`,`" .
                FIELD_MSGBRD_LINK . "`,`" .
                FIELD_MSG_TYPE_ID . "`,`" .
                FIELD_MSGBRD_FROM . "`,`" .
                FIELD_MSGBRD_TO . "`,`" .
                FIELD_MSGBRD_DEADLINE . "`,`" .
                FIELD_MSGBRD_ORIGINAL_CREATOR_ID . "`,`" .
                FIELD_MSGBRD_ORIGINAL_TYPE_ID . "`,`" .
                FIELD_MSGBRD_CREATE_TIME . "`" .
                " FROM `" . TBL_MESSAGEBOARD . "`" .
                " WHERE `" . FIELD_MSGBRD_ID . "` = '" . $id . "'";
        $this->dbquery($query);
        if ($this->checkDbErrors($query)) {
            return FALSE;
        }
        $msg_array = $this->dbFetchArray();

        if ($msg_array !== FALSE) {

            /* Save class data */
            $this->id = $id;
            $this->status_id = $msg_array[FIELD_MSG_STATUS_ID];
            $this->prio_level = $msg_array[FIELD_MSG_PRIO_LEVEL];
            $this->title = $msg_array[FIELD_MSGBRD_TITLE];
            $this->desc = $msg_array[FIELD_MSGBRD_DESC];
            $this->link = $msg_array[FIELD_MSGBRD_LINK];
            $this->type_id = $msg_array[FIELD_MSG_TYPE_ID];
            $this->from = $msg_array[FIELD_MSGBRD_FROM];
            $this->to = $msg_array[FIELD_MSGBRD_TO];
            $this->deadline = $msg_array[FIELD_MSGBRD_DEADLINE];
            $this->orig_create_id = $msg_array[FIELD_MSGBRD_ORIGINAL_CREATOR_ID];
            $this->orig_create_type_id = $msg_array[FIELD_MSGBRD_ORIGINAL_TYPE_ID];
            $this->createtime = $msg_array[FIELD_MSGBRD_CREATE_TIME];

            return TRUE;
        }
        return FALSE;
    }

    private function createTable() {

        /* Table Messageboard */
        $q = "CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`" . TBL_MESSAGEBOARD . "` (" .
                "`" . FIELD_MSGBRD_ID . "` bigint(10) NOT NULL AUTO_INCREMENT," .
                "`" . FIELD_MSG_STATUS_ID . "` bigint(10) NOT NULL," .
                "`" . FIELD_MSG_PRIO_LEVEL . "` varchar(" . LEN_MSG_PRIO_LEVEL . ") collate latin1_general_cs NOT NULL," .
                "`" . FIELD_MSGBRD_TITLE . "` varchar(" . LEN_MSGBRD_TITLE . ") collate latin1_general_cs NOT NULL," .
                "`" . FIELD_MSGBRD_DESC . "` varchar(" . LEN_MSGBRD_DESC . ") collate latin1_general_cs NOT NULL," .
                "`" . FIELD_MSG_TYPE_ID . "` bigint(10) NOT NULL," .
                "`" . FIELD_MSGBRD_FROM . "` bigint(10) NOT NULL," .
                "`" . FIELD_MSGBRD_TO . "` bigint(10) NOT NULL," .
                "`" . FIELD_MSGBRD_DEADLINE . "` timestamp NULL default NULL," .
                "`" . FIELD_MSGBRD_CREATE_TIME . "` timestamp NOT NULL default CURRENT_TIMESTAMP," .
                "`" . FIELD_MSGBRD_ORIGINAL_TYPE_ID . "` bigint(10) NOT NULL," .
                "`" . FIELD_MSGBRD_ORIGINAL_CREATOR_ID . "` bigint(10) NOT NULL," .
                "`" . FIELD_MSGBRD_LINK . "` varchar(" . LEN_MSGBRD_LINK . ") collate latin1_general_cs NOT NULL," .
                "PRIMARY KEY  (`" . FIELD_MSGBRD_ID . "`)," .
                "KEY `idx_" . FIELD_MSG_PRIO_LEVEL . "` (`" . FIELD_MSG_PRIO_LEVEL . "`)," .
                "KEY `idx_" . FIELD_MSG_STATUS_ID . "` (`" . FIELD_MSG_STATUS_ID . "`)," .
                "KEY `idx_" . FIELD_MSGBRD_TO . "` (`" . FIELD_MSGBRD_TO . "`)" .
                ") ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs";

        if (!$this->dbquery($q)) {
            $this->checkDbErrors($q);
            trigger_error(__FILE__ . ' ' . __LINE__ . ' Found errors ' . __FUNC__ . '<br/>');
            return FALSE;
        }
    }

}

class TestDbMessageBoard {

    public function TestDbMessageBoard() {

        echo "Test 1 DbMessageboard: new klasse &amp;&amp; save<br />";
        $test = new DbMessageBoard();

        $test->save(1, 'A', 'Dit is de title', 'dit is de beschrijving', 'linkto?id=1234543', 1, 1, 1, time());

        /*
          echo "<pre>";
          var_dump($test);
          echo "</pre>";
          // */

        echo "Test 2 DbMessageboard: nieuwe klasse met Id (moet gevuld worden uit DB.<br />";
        $test2 = new DbMessageBoard(1);
        /*
          echo "<pre>";
          var_dump($test2);
          echo "</pre>";
          // */
    }

}

?>
