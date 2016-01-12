<?php
    define("ROOT", dirname(__DIR__)."/telegram/");

    include(ROOT."secret.php");
    include(ROOT."config.php");

    include(ROOT."plugins/manager.php");
    include(ROOT."system/api.class.php");
    include(ROOT."system/mysqli.class.php");
    include(ROOT."system/shell.class.php");
    include(ROOT."system/translator.class.php");
    include(ROOT."api/Telegram.php");
?>
