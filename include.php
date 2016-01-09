<?php
    define("ROOT", dirname(__DIR__)."/telegram/");

    include(ROOT."secret.php");
    include(ROOT."config.php");

    include(ROOT."plugins/manager.php");
    include(ROOT."api.class.php");
    include(ROOT."mysqli.class.php");
    include(ROOT."shell.class.php");
    include(ROOT."api/Telegram.php");
?>
