<?php
    $aliases = array("youtube" => "youtube", "yt" => "youtube", "dlv" => "youtube");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $pluginManager->registerReceiver("youtube");
    $helps = array(
        "Send a youtube URL (may be shortened) - receive the downloaded video (up to 50MB)",
        "Send a URL that ends with `.mp4` to receive that file",
        "Use /dlv `URL` to download a video from the given URL"
    );
    $pluginManager->addHelp("youtube", $helps);
?>
