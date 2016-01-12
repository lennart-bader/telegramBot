<?php
    define("ROOT", dirname(__DIR__)."/telegram/");

    function __autoload($class) {
        $class = strtolower($class);
        $file = "plugins/" . $class . "/plugin.php";
        if (file_exists($file)) {
            require_once $file;    
        } else {
            $file = "system/api/".$class.".class.php";
            if (file_exists($file)) {
                require_once $file;
            }
        }        
    }

    include(ROOT."secret.php");
    include(ROOT."config.php");

    include(ROOT."plugins/manager.php");
    include(ROOT."system/mysqli.class.php");
    include(ROOT."system/shell.class.php");
    include(ROOT."system/translator.class.php");
    include(ROOT."api/Telegram.php");
?>
