<?php

use minevents\app\classes\Mail;
use minevents\app\classes\Persoon;

$persoon = new Persoon;
$groups = $persoon->getGroepList();

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
            $from_name = (isset($_POST['From_Name'])) ? $_POST['From_Name'] : '';
            $from_email = (isset($_POST['From_Email'])) ? $_POST['From_Email'] : '';
            $to_name = (isset($_POST['To_Name'])) ? $_POST['To_Name'] : '';
            $to_email = (isset($_POST['To_Email'])) ? $_POST['To_Email'] : '';
            $cc_email = (isset($_POST['cc_Email'])) ? $_POST['cc_Email'] : '';
            $bcc_email = (isset($_POST['bcc_Email'])) ? $_POST['bcc_Email'] : '';
            $subject = (isset($_POST['Subject'])) ? $_POST['Subject'] : '';
            $message = (isset($_POST['Message'])) ? $_POST['Message'] : '';
            ?>
        <body>
            <form>
                <div>
                    <div id="result2"></div>
                    <div class="column-left">
                        <table border="1" class="formulier">
                            <tr>
                                <td class="colleft">
                                    <label for="To_Email"><strong>Aan</strong> Email</label>
                                </td>
                                <td class="colrite">
                                    <input type="text" id="To_Email" name="To_Email" value="<?php echo $to_email; ?>"
                                           style="width:60%;" placeholder="Ontvanger.adres@example.com">
                                </td>
                            </tr><tr>
                                <td class="colleft">
                                    <label for="To_Email_Group"><strong>Aan</strong> Email</label>
                                </td>
                                <td class="colrite">
                                    <select id="To_Email_Group" name="To_Email_Group">
                                        <option value="0">Geen groep</option>
                                        <?php 
                                        foreach($groups as $group){
                                            echo "<option value='".$group['persoon_groep_id']."'>".$group['persoon_groep_naam']."</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="colleft">
                                    <label for="Subject"><strong>Onderwerp</strong></label>
                                </td>
                                <td class="colrite">
                                    <input type="text" name="Subject" id="Subject" value="<?php echo $subject; ?>"
                                           style="width:60%;" placeholder="Email Onderwerp">
                                </td>
                            </tr>
                            <tr>
                                <td class="colleft">
                                    <label for="Message"><strong>Bericht</strong><br>
                                    </label>
                                </td>
                                <td class="colrite">
                                    <div class="content-container">
                                        <div class="editor-wrapper" style="width:75%;" textarea>
                                            <div id="formatting-container">
                                                <select title="Font" class="ql-font">
                                                    <option value="sans-serif" selected>Sans Serif</option>
                                                    <option value="Georgia, serif">Serif</option>
                                                    <option value="Monaco, 'Courier New', monospace">Monospace</option>
                                                </select>
                                                <select title="Size" class="ql-size">
                                                    <option value="10px">Klein</option>
                                                    <option value="13px" selected>Normaal</option>
                                                    <option value="18px">Groot</option>
                                                    <option value="32px">Super groot</option>
                                                </select>
                                                <select title="Text Color" class="ql-color">
                                                    <option value="rgb(255, 255, 255)">Wit</option>
                                                    <option value="rgb(0, 0, 0)" selected>Zwart</option>
                                                    <option value="rgb(255, 0, 0)">Rood</option>
                                                    <option value="rgb(0, 0, 255)">Blauw</option>
                                                    <option value="rgb(0, 255, 0)">Groen</option>
                                                    <option value="rgb(0, 128, 128)">Blauwgroen</option>
                                                    <option value="rgb(255, 0, 255)">Roodpaars</option>
                                                    <option value="rgb(255, 255, 0)">Geel</option>
                                                </select>
                                                <select title="Background Color" class="ql-background">
                                                    <option value="rgb(255, 255, 255)" selected>Wit</option>
                                                    <option value="rgb(0, 0, 0)">Zwart</option>
                                                    <option value="rgb(255, 0, 0)">Rood</option>
                                                    <option value="rgb(0, 0, 255)">Blauw</option>
                                                    <option value="rgb(0, 255, 0)">Groen</option>
                                                    <option value="rgb(0, 128, 128)">Blauwgroen</option>
                                                    <option value="rgb(255, 0, 255)">Roodpaars</option>
                                                    <option value="rgb(255, 255, 0)">Geel</option>
                                                </select>
                                                <select title="Text Alignment" class="ql-align">
                                                    <option value="left" selected>Links</option>
                                                    <option value="center">Gecenteerd</option>
                                                    <option value="right">Rechts</option>
                                                    <option value="justify">Justify</option>
                                                </select>
                                                <button type="button" style="color: black" title="Bold" class="ql-bold" >Dikgedrukt</button>
                                                <button type="button" style="color: black" title="Italic" class="ql-italic">Schuingedrukt</button>
                                                <button type="button" style="color: black" title="Underline" class="ql-underline">Onderlijnd</button>
                                                <button type="button" style="color: black" title="Strikethrough" class="ql-strike">Doorstreept</button>
                                                <button type="button" style="color: black" title="Link" class="ql-link">Link</button>
                                                <button type="button" style="color: black" title="Image" class="ql-image">Plaatje</button>
                                                <button type="button" style="color: black" title="Bullet" class="ql-bullet">Puntenlijst</button>
                                                <button type="button" style="color: black" title="List" class="ql-list">Nummerieklijst</button>
                                            </div>
                                            <div id="editor-container"></div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        </table>

                        <input type="button" class="knopje" value="Versturen" name="submit" onclick="sendData();">

                    </div>
                    
                    <script type="text/javascript" src="js/jquery-2.0.2.js"></script>
                    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.js"></script>
                    <script type="text/javascript" src="js/quill.js"></script>

                    <script type="text/javascript">
                            var editor = new Quill('#editor-container', {
                             
                             modules: {
                             'toolbar': {container: '#formatting-container'},
                             'link-tooltip': true,
                             'image-tooltip': true
                             }
                             });
                             editor.addModule('toolbar', {
                             container: '#toolbar'
                             });
                             editor.on('selection-change', function(range) {
                             //console.log('selection-change', range)
                             });
                             editor.on('text-change', function(delta, source) {
                             //console.log('text-change', delta, source);
                             }); 

                            function sendData() {
                                
                                var html = editor.getHTML();

                                var To_Email = $('#To_Email').val();
                                
                                var To_Email_Group = $('#To_Email_Group').val();

                                var Subject = $('#Subject').val();
                                //To_Name:To_Name,To_Email:To_Email,Subject:Subject
                                $.post('includes/validate.php', {To_Email_Group : To_Email_Group, To_Email: To_Email, Subject: Subject, html: html},
                                function(data) {
                                    $('#result2').html(data);
                                });

                            }
                    </script>
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