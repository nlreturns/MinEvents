<?php
require_once 'error.php';
require_once FILE_DB_ROOSTER_TIJDBLOK;
/**
 * Description of tijdblok
 *
 * @version 0.1
 */
class Tijdblok extends Error {
    
    private $id;
    private $begintijd = '';
    private $eindtijd = '';
    private $rooster_id = '';

    /**
     *
     * @param int $id optional or current tijd_id
     */
    public function Tijdblok($id=''){
        if ( !empty($id) ){
            /* Load class vars */
            $db = new DbTijdblok($id);
            if ((!$db === FALSE) || ($db === '')){
                $this->id = $id;
                $this->getTijdID($id);
            } 
        }
    }
public function getRoosterId(){
       return $this->rooster_id;
}
      
    
   public function getTijdId(){
       return $this->id;
    }

    public function setBegintijd($begintijd){
            $this->begintijd = $begintijd;

      
    }
    
    public function setEindtijd($eindtijd){
            $this->eindtijd = $eindtijd;
    }
   public function setRoosterId($rooster_id){
        if(!empty($rooster_id)){
            $this->rooster_id = trim($rooster_id);
            return TRUE;
        }else{
        return FALSE;
        }
    }

    /** Retrieve begintijd
     * @param <type> $begintijd
     * @return timestamp begintijd from tijdblok
     */
    public function getBegintijd() {
        return $this->begintijd;
    }
    /** Retrieve eindtijd
     * @param <type> $eindtijd
     * @return timestamp eindtijd from tijdblok
     */    
    public function getEindtijd() {
        return $this->eindtijd;
    }
    /**
     * @param string $roosterstatus Status from rooster
     * @param string $tekst Tekst can be included
     * @param string $aanmaakpersoon Peron who made rooster
     */
    
    public function saveTijdblok(){
        $db_tijdblok = new DbTijdblok();
        if (!$db_tijdblok->save($this->rooster_id, $this->begintijd, $this->eindtijd)){
            $this->setErrorArray($db_tijdblok->getErrorArray());
            return FALSE;
        } 
        $this->id = $db_tijdblok->getTijdId();
        // create notification
        return TRUE;
    }
    /**
     *  Change all entry's from rooster
     * @return bool
     */
   public function wijzigTijdblok(){
       $db_rooster = new DbRooster($this->tijd_id);
       
       if (!$db_rooster->updateRooster($this->roosterstatus_id, $this->roosterstatus, $this->tekst, $this->aanmaakpersoon)){
           $this->setErrorArray($db_rooster->getErrorArray());
           return FALSE;
       }
       return TRUE;
   }

    /**
     *  Select all entry's from rooster
     * @return bool
       
   public function selectRooster(){
       $db_rooster = new DbRooster($this->id);
       
       if (!$db_rooster->getRooster($rooster_id)){
           $this->setErrorArray($db_rooster->getErrorArray());
           return FALSE;
       }
       return TRUE;
   }
   public function verwijderRooster(){
       $db_rooster = new DbRooster($this->rooster_id);
	   
       if(!$db_rooster->deleteRooster()){
           $this->setErrorArray($db_rooster->getErrorArray());
           return FALSE;
       }
       return TRUE;
   }*/

}

class TestTijdblok {

    public function TestTijdblok(){
        echo '<hr />Nieuw Tijdblok<br />';        
        $test = new Tijdblok();
        
        $test->setRoosterId(1);
        $test->setBegintijd('2012-02-01 20:37:24');
        $test->setEindtijd('2012-02-01 20:37:24');        
        
        if (!$test->saveTijdblok()){
            $errs = $test->getErrorArray();
            foreach($errs as $idx => $error){
                echo "$error<br />\n";
            }
        }         

        /*
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
           //*/

    }

}

?>
