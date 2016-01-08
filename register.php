<?php
    include("include.php");
   
    echo "Setting Webhook to " . TELEGRAM_LISTENER_URL . "<br />";
    echo Api::setWebhook(TELEGRAM_LISTENER_URL);
    
?>