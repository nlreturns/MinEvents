<?php

namespace minevents\app\classes;




class Mail {

    private $phpmailer;
    private $configArray;
    public $message;

    public function __construct(\PHPMailer $PHPMailer, Configuration $config) {
        $this->phpmailer = $PHPMailer;
        $this->configArray = $config->getIniArray('Mail');
        $this->setUsername();
        $this->setPassword();
    }

    private function setSMTP() {
        $this->phpmailer->isSMTP();
        $this->phpmailer->Host = $this->configArray['smtp_host'];
        $this->phpmailer->Port = $this->configArray['smtp_port'];
        $this->phpmailer->SMTPDebug = $this->configArray['smtp_debug'];
        $this->phpmailer->Debugoutput = $this->configArray['debug_output'];
        $this->phpmailer->SMTPSecure = $this->configArray['smtp_secure'];
        $this->phpmailer->SMTPAuth = $this->configArray['smtp_auth'];
    }

    public function sendMail() {
        $this->setSMTP(new Configuration(CONFIG_FILE));
        $this->phpmailer->msgHTML($this->message);
        if (!$this->phpmailer->send()) {
            echo "Mailer Error: " . $this->phpmailer->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

    public function setFrom($from) {
        if(!empty($from)) {
            $this->phpmailer->From = $from;
        }
    }

    public function setReplyTo($replyMail, $replyName) {
        if(!empty($replyMail) && !empty($replyName)) {
            $this->phpmailer->addReplyTo($replyMail, $replyName);
        }
    }

    public function setAddress($mail, $name) {
        if(!empty($mail) && !empty($name)) {
            $this->phpmailer->addAddress($mail, $name);
        }
    }

    public function setSubject($subject) {
        if(!empty($subject)) {
            $this->phpmailer->Subject = $subject;
        } else {
            $this->phpmailer->Subject = '';
        }
    }

    public function setMessage($template = null, $message = null) {
        if(!empty($template)) {
            ob_start();
            $this->message = include './html/mailtemplates/' . $template;
            ob_end_flush();
        } elseif(!empty($message)) {
            $this->message = $message;
        }
    }

    public function setUsername($username = null) {
        if(!empty($username)) {
            $this->phpmailer->Username = $username;
        } else {
            $this->phpmailer->Username = $this->configArray['gmail_user'];
        }
    }

    public function setPassword($password = null) {
        if(!empty($password)) {
            $this->phpmailer->Password = $password;
        } else {
            $this->phpmailer->Password = $this->configArray['gmail_pass'];
        }
    }
} 