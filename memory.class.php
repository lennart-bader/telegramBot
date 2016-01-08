<?php
/*
 * This class represents the memory of the bot.
 * It stores active chatids and the time of the last received message
 */
define("s_memory_table", "s_memory");
define("s_memory_id", "id");
define("s_memory_chat", "chat");
define("s_memory_members", "members");
define("s_memory_lastmessage", "lastmessage");
define("s_memory_lastmessageauthor", "lastauthor");
define("s_memory_lastbotmessage", "lastbotmessage");

class Memory {
    public function __construct() {
        // Check if DB table exists
        global $db;
        $query = "SHOW TABLES LIKE `".p_hangman_table."`";
        $db->query($query);
        if ($db->numRows() == 0) {
            // Table does not exist
            $this->setupDb();
        }                  
    }

    public function onMessageReceived() {
        global $db;
        global $chatid;
        global $message;
        
        if ($this->chatExists($chatid)) {
            $this->updateChat($chatid, $message);
        } else {
            $this->createChat($chatid, $message);
        }        
    }

    private function setupDb() {
        global $db;
        $query = "
            CREATE TABLE `".s_memory_table."` (
                `".s_memory_id."` BIGINT NOT NULL AUTO_INCREMENT,
                `".s_memory_chat."` BIGINT NOT NULL,
                `".s_memory_members."` TEXT NOT NULL,
                `".s_memory_lastmessage."` BIGINT NOT NULL,
                `".s_memory_lastmessageauthor."` BIGINT NOT NULL,
                `".s_memory_lastbotmessage."` BIGINT NOT NULL,
                PRIMARY KEY (`".s_memory_id."`)
            );
        ";
        $db->query($query);
    }

    private function updateChat($conv, $chatid, $message) {
        global $db;
        $query = "
            UPDATE `".s_memory_table."` SET 
            
            WHERE `".s_memory_chat."` = '".$chatid."';
            ";
    }
    
    private function createChat($chatid, $message) {
        global $db;
        $query = "
                INSERT INTO `".s_memory_table."` (
                    `".s_memory_chat."`,
                    `".s_memory_members."`,
                    `".s_memory_lastmessage."`,
                    `".s_memory_lastmessageauthor."`,
                    `".s_memory_lastbotmessage."`
                ) VALUES (
                    '".$chatid."',
                    '".json_encode(array($message["from"]))."',
                    '".time()."',
                    '".$message["from"]["id"]."',
                    '0'
                );
        ";
        $db->query($query);
        return ($db->affected_rows() > 0);
    }
}
?>
