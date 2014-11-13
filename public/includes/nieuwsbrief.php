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
            require "..\..\minevents\libs\class.phpmailer.php";
            require "..\app\classes\Mail.php";
            
            //namespace minevents\public\includes\nieuwsbrief;
            //use minevents\app\classes\Mail;
            
            $mail = new Mail();
            
            $CFG['smtp_debug'] = 2; //0 == off, 1 for client output, 2 for client and server
            $CFG['smtp_debugoutput'] = 'html';
            $CFG['smtp_server'] = 'smtp.gmail.com';
            $CFG['smtp_port'] = '587';
            $CFG['smtp_authenticate'] = true;
            $CFG['smtp_username'] = 'noreplyminevents@gmail.com';
            $CFG['smtp_password'] = 'Carolien123';
            $CFG['smtp_secure'] = 'tls';

            $from_name = (isset($_POST['From_Name'])) ? $_POST['From_Name'] : '';
            $from_email = (isset($_POST['From_Email'])) ? $_POST['From_Email'] : '';
            $to_name = (isset($_POST['To_Name'])) ? $_POST['To_Name'] : '';
            $to_email = (isset($_POST['To_Email'])) ? $_POST['To_Email'] : '';
            $cc_email = (isset($_POST['cc_Email'])) ? $_POST['cc_Email'] : '';
            $bcc_email = (isset($_POST['bcc_Email'])) ? $_POST['bcc_Email'] : '';
            $subject = (isset($_POST['Subject'])) ? $_POST['Subject'] : '';
            $message = (isset($_POST['Message'])) ? $_POST['Message'] : '';
            $test_type = (isset($_POST['test_type'])) ? $_POST['test_type'] : 'smtp';
            $smtp_debug = (isset($_POST['smtp_debug'])) ? $_POST['smtp_debug'] : $CFG['smtp_debug'];
            $smtp_server = (isset($_POST['smtp_server'])) ? $_POST['smtp_server'] : $CFG['smtp_server'];
            $smtp_port = (isset($_POST['smtp_port'])) ? $_POST['smtp_port'] : $CFG['smtp_port'];
            $smtp_secure = strtolower((isset($_POST['smtp_secure'])) ? $_POST['smtp_secure'] : $CFG['smtp_secure']);
            $smtp_authenticate = (isset($_POST['smtp_authenticate'])) ?
                    $_POST['smtp_authenticate'] : $CFG['smtp_authenticate'];
            $authenticate_password = (isset($_POST['authenticate_password'])) ?
                    $_POST['authenticate_password'] : $CFG['smtp_password'];
            $authenticate_username = (isset($_POST['authenticate_username'])) ?
                    $_POST['authenticate_username'] : $CFG['smtp_username'];
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
                                        <label for="From_Name"><strong>From</strong> Name</label>
                                    </td>
                                    <td class="colrite">
                                        <input type="text" id="From_Name" name="From_Name" value="<?php echo $from_name; ?>"
                                               style="width:95%;" autofocus placeholder="Your Name">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="colleft">
                                        <label for="From_Email"><strong>From</strong> Email Address</label>
                                    </td>
                                    <td class="colrite">
                                        <input type="text" id="From_Email" name="From_Email" value="<?php echo $from_email; ?>"
                                               style="width:95%;" required placeholder="Your.Email@example.com">
                                    </td>
                                </tr>
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
                                        <label for="cc_Email"><strong>CC Recipients</strong><br>
                                            <small>(separate with commas)</small>
                                        </label>
                                    </td>
                                    <td class="colrite">
                                        <input type="text" id="cc_Email" name="cc_Email" value="<?php echo $cc_email; ?>"
                                               style="width:95%;" placeholder="cc1@example.com, cc2@example.com">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="colleft">
                                        <label for="bcc_Email"><strong>BCC Recipients</strong><br>
                                            <small>(separate with commas)</small>
                                        </label>
                                    </td>
                                    <td class="colrite">
                                        <input type="text" id="bcc_Email" name="bcc_Email" value="<?php echo $bcc_email; ?>"
                                               style="width:95%;" placeholder="bcc1@example.com, bcc2@example.com">
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
                            <div style="margin:1em 0;">Test will include two attachments.</div>
                        </fieldset>
                    </div>

                    <?php echo 'Current PHP version: ' . phpversion(); ?>
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