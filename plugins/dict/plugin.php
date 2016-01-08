<?php
class Dict {
    public function execute($data, $message) {
        global $pluginManager; 
        global $api;
        global $chatid;
        global $sender;

        $cmd = explode("_", $data[0]);
        array_shift($data);
        $search = implode(" ", $data);
        $from = $cmd[1];
        $to = $cmd[2];

        $res = $this->getTranslation($from, $to, $search);
        if ($res == false) {
            $reply = "No translation found :(";
        } else {
            $reply = $res;
        }

        $api->sendMessage($chatid, $reply, "Markdown", true);
    }

    private function getTranslation($from, $to, $search) {
        $url = "https://glosbe.com/gapi/translate?from=" . urlencode($from) . "&dest=" . urlencode($to);
        $url .= "&format=json&phrase=" . urlencode($search);
        $res = json_decode(file_get_contents($url), true);
        if ($res["result"] == "ok") {
            $translation = $res["tuc"][0];
            $respond = $search . ": " . html_entity_decode($translation["phrase"]["text"]) ;
            foreach ($translation["meanings"] as $id => $m) {
                $respond .= "\n" . ($id + 1) . ".: ". html_entity_decode($m["text"]);
            }
            return $respond;
        } else {
            return false;
        }
    }
    
}
?>
