<?php
namespace minevents\app\classes;
use minevents\app\classes\db\DbMessageBoard as DbMessageBoard;
/**
 * This is the class that facilitates
 *  the messageboard functionality.
 *
 * @author GHoogendoorn
 * @version 0.1
 */
class MessageBoard extends Error {

    private $id;
    private $pers_id;

    /**
     *
     * @param int $id optional or current msg_id
     */
    public function MessageBoard($id=''){
        if ( !empty($id) ){
            /* Load class vars */
            $db = new DbMessageBoard($id);
            if ((!$db === FALSE) || ($db === '')){
                $this->id = $id;
                $this->getMessage($id);
            
            }
        }
    }

    /**
     * @param string $msg_titel Titel from message
     * @param string $msg_desc Further description.
     * @param string $link ' ' OR Link or part of link that can be followed
     * @param int $msg_type (from pers or module) MSG_TYPE_PERSON_x
     * @param int $from (person id or module id)
     * @param int $to   (receiver of this message)
     * @param timestamp $msg_deadline (optional)
     * @return boolean
     */
    public function newMessage($msg_desc,$link,$to = null){
        $db_msgbrd = new DbMessageBoard();

        if (!$db_msgbrd->save( $msg_desc, $link, $to )){
            $this->setErrorArray($db_msgbrd->getErrorArray());
            return FALSE;
        } 
        $this->id = $db_msgbrd->getMessageId();
        return TRUE;
    }

    /**
     *
     * The message is forwarded to the person/module ($to_id)
     *
     * @param int $to_id Person id to forward msg to.
     */
    public function forwardMessage($to_id){

        $db = new DbMessageBoard();

        /* Update originator / recipient */

    }

    



    /**
     * getMessage()
     *
     *  Retrieve all message information
     *      for this Id with given STATUS
     * @param <type> $id
     */
    public function getMessage($id){

        /* Return class vars */
        $db = new DbMessageBoard();
        $data_array = $db->getMessage($id);
        $this->id = $id;
        return $data_array;
    }

    /**
     *
     * @param string $type Type of Message
     * @return <type>
     */
    public function getMessageTypeId($type){
        $db = new DbMessageboardType();
        $id= $db->getIdByName($type);
        if ($id === FALSE ){
            $this->setErrorArray($db->getErrorArray());
            /* return FALSE id anyway */
        }
        return $id;
    }

    /**
     *  Change the description of the message
     *
     * @param string $desc Nes Description
     * @return bool
     */
    public function changeMessageDesc($desc){
        if ( empty($this->id) ){
            $this->setError(__FUNCTION__ . TXT_ERROR_NO_ID );
            return FALSE;
        }
        $db = new DbMessageBoard($this->id);
        if (!$db->updateMessageDesc($desc)){
            $this->setErrorArray($db->getErrorArray());
            return FALSE;
        }
        return TRUE;
    }

    /**
     *  Change the current me
     * @param <type> $new_status
     * @return <type>
     */
    public function changeMessageStatus($new_status){
        if ( empty($this->id) ){
            $this->setError(__FUNCTION__ . TXT_ERROR_NO_ID );
            return FALSE;
        }

        $db = new DbMessageBoard($this->id);
        if( !$db->updateMessageStatus($new_status)){
            /* Get the database error array in this class */
            $this->setErrorArray($db->getErrorArray());
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     * closeMessage()
     *
     *  Set the status of this message to CLOSED | FINISHED
     *
     */
    public function closeMessage(){
        return $this->changeMessageStatus(MSG_STATUS_CLOSED);
    }

    /**
     *  Retrieve the not closed messages for this recipient
     *
     * @param <type> $id
     */
    public function getUserMessageBoard($id = null, $limit=15, $start=0){
        
        $db = new DbMessageBoard($this->id);
        
        return $db->getMessageListForUser($id, $limit, $start);
    }
    
    private function getMessageStatusArray($type_id){
        $return_array = array();
        
        /* Return array with status id's */
        if ( ($type_id == MSG_STATUS_NOT_CLOSED) || 
             ($type_id == MSG_STATUS_ALL ) ){
            
            /* All individual but the CLOSED status */
            $return_array[] = MSG_STATUS_NEW;
            $return_array[] = MSG_STATUS_INPROGRESS;
            
            if ( $type_id == MSG_STATUS_ALL ){
                /* Include also closed status */
                $return_array[] = MSG_STATUS_CLOSED;
            }
            
        } else {
            
            /* Return the individual type in an array */
            $return_array[] = $type_id;
        }
        
        return $return_array;
    }
}

class TestMessageBoard {

    public function TestMessageBoard(){
        $test = new MessageBoard();

        echo '<hr />Nieuwe message (Nieuwe mail)<br />';
        if (!$test->newMessage('Nieuw mail', 'Wil je dit mailtje controleren?','messageboard?id=1234',MSG_TYPE_MODULE, 1, 2)){
            $errs = $test->getErrorArray();
            foreach($errs as $idx => $error){
                echo "$error<br />\n";
            }
        }
        debug_var_dump($test);
        echo '<hr />Get message type MSG_TYPE_PERSON<br />';
        $type = $test->getMessageTypeId(MSG_TYPE_PERSON);
        debug_var_dump($type);

        echo '<hr /><p>Nieuwe message (Nieuwe ticket)<br />';
        if (!$test->newMessage('Nieuwe ticket', 'Blah blah blah','messageboard?id=4321', MSG_TYPE_PERSON,1, 2)){
            $errs = $test->getErrorArray();
            foreach($errs as $idx => $error){
                echo "$error<br />\n";
            }
        }
        debug_var_dump($test);
        
        echo '<hr />Nieuwe update message beschrijving<br />';
        if (!$test->changeMessageDesc('Nieuwe beschrijving')){
            $errs = $test->getErrorArray();
            foreach($errs as $idx => $error){
                echo "$error<br />\n";
            }
        }
        debug_var_dump($test);

        $msg_array = $test->getMessage(1);
        debug_var_dump($msg_array);

        echo '<hr />Update message status to in progress...<br />';
        $test->changeMessageStatus(MSG_STATUS_INPROGRESS);
        debug_var_dump($test);

        echo '<hr />Update message status to in closed...<br />';
        $msg_array = $test->getMessage(3);
        $test->closeMessage();

        echo '<hr />Get Messagelist per sentto id..<br />';
        
        $msg_list = $test->getUserMessageBoard(1);
        
        
        
    }

}
?>
