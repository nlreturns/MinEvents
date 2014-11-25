<?php

use minevents\app\classes\Mail;
?>
<div id="subnav">
    <div id="halvecirkel">
        <a href="?page=dashboard"><img src="img/home_button.png" /></a>
    </div>
    <ul>
    </ul>
</div>

<div class="contentarea">
    <?php
    if (isset($_GET['subpage'])) {
        switch ($_GET['subpage']) {
            case "ticketformulier": include 'ticketformulier.php';
                break;
            case "ticketoverzicht": include 'ticketoverzicht.php';
                break;
            case "eigentickets": include 'eigentickets.php';
                break;
        }
    } else {
        ?>
        <h2>Nieuwsbrief</h2>

        <p>
            <?php
            /*
             * A web form that both generates and uses PHPMailer code.
             * revised, updated and corrected 27/02/2013
             * by matt.sturdy@gmail.com
             */

            require "..\..\minevents\libs\PHPMailerAutoload.php";
            //require "..\..\minevents\libs\class.phpmailer.php";
            //require "..\app\classes\Mail.php";
            //namespace minevents\public\includes\nieuwsbrief;
            //use minevents\app\classes\Mail;

            $CFG['smtp_debug'] = 2; //0 == off, 1 for client output, 2 for client and server
            $CFG['debug_output'] = 'html';
            $CFG['smtp_host'] = 'smtp.gmail.com';
            $CFG['smtp_port'] = '587';
            $CFG['smtp_auth'] = true;
            $CFG['smtp_username'] = 'noreplyminevents@gmail.com';
            $CFG['smtp_password'] = 'Carolien123';
            $CFG['smtp_secure'] = 'tls';
            $CFG['gmail_user'] = 'noreplyminevents@gmail.com';
            $CFG['gmail_pass'] = 'Carolien123';

            //$mailer = new Mail(new PHPMailer, $CFG);

            $mail = new PHPMailer();

            if (isset($_POST['submit'])) {

                //Tell PHPMailer to use SMTP
                $mail->isSMTP();

                //Enable SMTP debugging
                // 0 = off (for production use)
                // 1 = client messages
                // 2 = client and server messages
                $mail->SMTPDebug = 2;

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
                $mail->addAddress($_POST['To_Email'], $_POST['To_Name']);

                //Set the subject line
                $mail->Subject = $_POST['Subject'];

                //Read an HTML message body from an external file, convert referenced images to embedded,
                //convert HTML into a basic plain-text alternative body
                $mail->msgHTML($_POST['Message']);

                $mail->addAttachment('../disney_frozen_500.jpg');

                //send the message, check for errors
                if (!$mail->send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                } else {
                    echo "Message sent!";
                }
            }

            $from_name = (isset($_POST['From_Name'])) ? $_POST['From_Name'] : '';
            $from_email = (isset($_POST['From_Email'])) ? $_POST['From_Email'] : '';
            $to_name = (isset($_POST['To_Name'])) ? $_POST['To_Name'] : '';
            $to_email = (isset($_POST['To_Email'])) ? $_POST['To_Email'] : '';
            $cc_email = (isset($_POST['cc_Email'])) ? $_POST['cc_Email'] : '';
            $bcc_email = (isset($_POST['bcc_Email'])) ? $_POST['bcc_Email'] : '';
            $subject = (isset($_POST['Subject'])) ? $_POST['Subject'] : '';
            $message = (isset($_POST['Message'])) ? $_POST['Message'] : '';
            ?>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <title>PHPMailer Test Page</title>
            <script type="text/javascript" src="scripts/shCore.js"></script>
            <script type="text/javascript" src="scripts/shBrushPhp.js"></script>
            <link type="text/css" rel="stylesheet" href="styles/shCore.css">
            <link type="text/css" rel="stylesheet" href="styles/shThemeDefault.css">
            <style>
                body {
                    font-family: Arial, Helvetica, sans-serif;
                    font-size: 1em;
                    padding: 1em;
                }

                table {
                    margin: 0 auto;
                    border-spacing: 0;
                    border-collapse: collapse;
                }

                table.column {
                    border-collapse: collapse;
                    background-color: #FFFFFF;
                    padding: 0.5em;
                    width: 35em;
                }

                td {
                    font-size: 1em;
                    padding: 0.1em 0.25em;
                    -moz-border-radius: 1em;
                    -webkit-border-radius: 1em;
                    border-radius: 1em;
                }

                td.colleft {
                    text-align: right;
                    width: 35%;
                }

                td.colrite {
                    text-align: left;
                    width: 65%;
                }

                fieldset {
                    padding: 1em 1em 1em 1em;
                    margin: 0 2em;
                    border-radius: 1.5em;
                    -webkit-border-radius: 1em;
                    -moz-border-radius: 1em;
                }

                fieldset.inner {
                    width: 40%;
                }

                fieldset:hover, tr:hover {
                    background-color: #fafafa;
                }

                legend {
                    font-weight: bold;
                    font-size: 1.1em;
                }

                div.column-left {
                    float: left;
                    width: 45em;
                    height: 31em;
                }

                div.column-right {
                    display: inline;
                    width: 45em;
                    max-height: 31em;
                }

                input.radio {
                    float: left;
                }

                div.radio {
                    padding: 0.2em;
                }
            </style>
            <script>
                SyntaxHighlighter.config.clipboardSwf = 'scripts/clipboard.swf';
                SyntaxHighlighter.all();

                function startAgain() {
                    var post_params = {
                        "From_Name": "<?php echo $from_name; ?>",
                        "From_Email": "<?php echo $from_email; ?>",
                        "To_Name": "<?php echo $to_name; ?>",
                        "To_Email": "<?php echo $to_email; ?>",
                        "cc_Email": "<?php echo $cc_email; ?>",
                        "bcc_Email": "<?php echo $bcc_email; ?>",
                        "Subject": "<?php echo $subject; ?>",
                        "Message": "<?php echo $message; ?>",
                        "test_type": "<?php echo $test_type; ?>",
                        "smtp_debug": "<?php echo $smtp_debug; ?>",
                        "smtp_server": "<?php echo $smtp_server; ?>",
                        "smtp_port": "<?php echo $smtp_port; ?>",
                        "smtp_secure": "<?php echo $smtp_secure; ?>",
                        "smtp_authenticate": "<?php echo $smtp_authenticate; ?>",
                        "authenticate_username": "<?php echo $authenticate_username; ?>",
                        "authenticate_password": "<?php echo $authenticate_password; ?>"
                    };

                    var resetForm = document.createElement("form");
                    resetForm.setAttribute("method", "POST");
                    resetForm.setAttribute("path", "index.php");

                    for (var k in post_params) {
                        var h = document.createElement("input");
                        h.setAttribute("type", "hidden");
                        h.setAttribute("name", k);
                        h.setAttribute("value", post_params[k]);
                        resetForm.appendChild(h);
                    }

                    document.body.appendChild(resetForm);
                    resetForm.submit();
                }

                function showHideDiv(test, element_id) {
                    var ops = {"smtp-options-table": "smtp"};

                    if (test == ops[element_id]) {
                        document.getElementById(element_id).style.display = "block";
                    } else {
                        document.getElementById(element_id).style.display = "none";
                    }
                }
            </script>
        </head>
        <body>
            <form method="POST" enctype="multipart/form-data">
                <div>
                    <div class="column-left">
                        <fieldset>
                            <legend>Mail Details</legend>
                            <table border="1" class="column">
                                <tr>
                                    <td class="colleft">
                                        <label for="To_Name"><strong>To</strong> Name</label>
                                    </td>
                                    <td class="colrite">
                                        <input type="text" id="To_Name" name="To_Name" value="<?php echo $to_name; ?>"
                                               style="width:95%;" placeholder="Recipient's Name">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="colleft">
                                        <label for="To_Email"><strong>To</strong> Email Address</label>
                                    </td>
                                    <td class="colrite">
                                        <input type="text" id="To_Email" name="To_Email" value="<?php echo $to_email; ?>"
                                               style="width:95%;" required placeholder="Recipients.Email@example.com">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="colleft">
                                        <label for="Subject"><strong>Subject</strong></label>
                                    </td>
                                    <td class="colrite">
                                        <input type="text" name="Subject" id="Subject" value="<?php echo $subject; ?>"
                                               style="width:95%;" placeholder="Email Subject">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="colleft">
                                        <label for="Message"><strong>Message</strong><br>
                                            <small>If blank, will use content.html</small>
                                        </label>
                                    </td>
                                    <td class="colrite">
                                        <textarea name="Message" id="Message" style="width:95%;height:5em;"
                                                  placeholder="Body of your email"><?php echo $message; ?></textarea>
                                    </td>
                                </tr>
                            </table>
                            <div style="margin:1em 0;">Test will include one attachment.</div>
                        </fieldset>
                        <input type="submit" value="Submit" name="submit">
                    </div>
            </form>
    </div>
    </div>
    </form>
    </body>
    </html>

    </p>
    </div>
    <?php
}
?>