<?php
namespace minevents\app\classes;
class Mail {
    
    private $to;
    private $from;
    private $subject;
    private $message = 'Dit is een automatisch verzonden bericht. <br />';
    private $headers;
    private $titel;
    private $afdeling;
    private $object;
    
    // verstuur de mail
    public function send() {
        $this->addHeader( 'From: no-reply@minevents.nl "\r\n" ');
        $this->addHeader('X-Mailer: PHP/'.phpversion());
        mail($this->to, $this->subject, $this->message, $this->headers);
    }
    
    // set de ontvanger
    public function setTo($to) {
        $this->to = $to;
    }
    
    // set het onderwerp van de mail
    public function setSubject($subject) {
        $this->subject = $subject;
    }
    
    // set het bericht
    public function setMessage($message) {
        if(!$message) {
            $this->message = 
                'Ticket <br />
                Afdeling:'.$this->afdeling.'<br />
                Object:'.$this->object. '<br />
                Titel:'.$this->titel.'<br />
                Beschrijving:'.$this->message.'<br /> 
                Dit is een automatisch verzonden bericht.';
        }
        $this->message .= $message;
    }
    
    // set afdeling
    public function setAfdeling($afdeling) {
        $this->afdeling = $afdeling;
    }
    
    // set object
    public function setObject($object) {
        $this->object = $object;
    }
    
    //get bericht
    public function getMessage() {
        return $this->message;
    }
    
    //get ontvanger
    public function getTo() {
        return $this->to;
    }
    
    
    //get afdeling
    public function getAfdeling() {
        return $this->afdeling;
    }
    
    
    //get object
    public function getObject() {
        return $this->object;
    }
    
    private function addHeader($header) {   
        $this->headers .= $header;   
    }
}
?>
