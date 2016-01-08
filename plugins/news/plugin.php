<?php
require_once("spiegel.class.php");

class News {
    public function execute($data, $message) {
        $cmd = $data[0];
        $cmd = explode($cmd, "-");
        if (sizeof($cmd) > 1) {        
                Api::reply($message, "Hier fehlt noch was");     
        } elseif (sizeof($data) > 1) {
            // ("/news SUCHE BEGRIFFE")
            unset($data[0]);        
            $spiegel = new Spiegel();
            $topics = $spiegel->search($data, true);
            if (!$topics) {
                Api::reply($message, "Keine News zu diesen Begriffen");                
            } else {
                $msg = array();
                $msg[] = '*Suchergebnisse zu "' . implode(", ", $data) . '":*';
                foreach ($topics as $topic) {
                    $msg[] = "";
                    $msg[] = "*".$topic["title"]."*";
                    $msg[] = $topic["description"];
                    $msg[] ="[Zum Artikel](" . $topic["link"] . ")";                    
                }
                Api::reply($message, implode("\n", $msg), true);  
            }
        } else {
            // List topics ("/news"
            $spiegel = new Spiegel();
            $topics = $spiegel->getLastTopics();
            if (!$topics) {
                Api::reply($message, "Derzeit keine News");                
            } else {
                $msg = array();
                $msg[] = "*Aktuelle Themen:*";
                foreach ($topics as $topic) {
                    $msg[] = "";
                    $msg[] = "*".$topic["title"]."*";
                    $msg[] = $topic["description"];
                    $msg[] ="[Zum Artikel](" . $topic["link"] . ")";                    
                }
                Api::reply($message, implode("\n", $msg), true);  
            }
        }
        
    }
}
?>