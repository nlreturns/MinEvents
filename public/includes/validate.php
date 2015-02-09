<?php
require "\..\..\..\minevents\libs\PHPMailerAutoload.php";

$mail = new PHPMailer();

if (isset($_POST['html'])) {
    
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;

    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';

    //Set the hostname of the mail server
    $mail->Host = 'mail.minevents.eu';

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 25;

    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "noreply@minevents.eu";

    //Password to use for SMTP authentication
    $mail->Password = "y7ZuCuMsX";

    //Set who the message is to be sent from
    $mail->setFrom("noreply@minevents.eu", "Nieuwsbrief");

    //Set who the message is to be sent to
    $mail->addAddress($_POST['To_Email'], "Klant");

    //Set the subject line
    $mail->Subject = $_POST['Subject'];

    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $_POST['html'] .= "<div>Do not reply to this mail</div>";
    $mail->msgHTML($_POST['html']);

    if($_POST['To_Email_Group'] == "0"){
        
    }else{
        
        $connection = new mysqli("localhost", "root", "", "minevents") or die('There was a problem connecting to the database');
        // get all persons from group
        $query = "SELECT * FROM `persoon` WHERE `persoon_groep` = " . $_POST['To_Email_Group'];
        
        $result = $connection->query($query);
        
        $result = $result->fetch_array(MYSQLI_ASSOC);
        
        foreach ($result as $field => $value) {
            if (is_numeric($value)) {
                continue;
            } else if (is_string($value)) {
                $data_array[$field] = trim(stripslashes($value));
            }
        }
        
        // loop their emails and send
        foreach($data_array as $person){
            //var_dump($person['persoon_email']);
            $mail->addAddress($person, "Klant");
        }
    }
    
    //send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
}
