<?php include_once 'classes/messageboard.php'; ?>
<div id="dashboard">
    <div id="left">
        <div id="messageboard">
            <?php
            
            $dashboard = new MessageBoard;
            
            $messages_personal = $dashboard->getUserMessageBoard($_SESSION['user_id']);
            $messages_global = $dashboard->getUserMessageBoard();
            
            echo '<h1>Globale berichten: </h1>';
            foreach($messages_global as $global_message){
                echo $global_message['msg_beschrijving'] . "<br />";
            }
            echo '<br />';
            echo '<br />';
            
            echo '<h1>Persoonlijke berichten: </h1>';
            foreach($messages_personal as $personal_message){
                echo "<a class='mblinks' href='" . $personal_message['msg_link'] . "'>" . $personal_message['msg_beschrijving'] . "</a><br />";
            }
            
            ?>
            <br />
        </div>
        <div id="cirkel">
            &nbsp;
        </div>
    </div>
    <nav id="dashnav">
        <ul>
            <li><a href="?page=nieuwsbrief"><img src="img/nieuwsbrief_button.png" alt="Nieuwsbrief" /></a></li>
            <li><a href="?page=personeel"><img src="img/personeel_button.png" alt="Personeel" /></a></li>
            <li><a href="?page=tickets"><img src="img/tickets_button.png" alt="Tickets" /></a></li>
            <li><a href="?page=rooster"><img src="img/rooster_button.png" alt="Rooster" /></a></li>
            <li><a href="?page=marketing"><img src="img/marketing_button.png" alt="Marketing" /></a></li>
        </ul>
    </nav>
</div>