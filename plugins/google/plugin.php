<?php
require_once("plugins/google/googlecache.php");

class Google {
    private $gc;

    public function execute($message) {
        $cmd = $message->getCommand();
        global $api;
        $this->gc = new GoogleCache();

        switch ($cmd) {
            case "g": 
                $lines = array();
                $res = $this->search(implode(" ", $message->getData()));
                foreach ($res as $id => $result) {
                    $lines[] = "*".$id." - ".Google::bToUS($result["title"])."*";
                    $lines[] = Google::bToUS($result["content"]);
                    $lines[] = "(" . Google::encodeUs($result["url"]) . ")";
                    $lines[] = "";
                }
                $api->sendMessage($message->chat->id, implode("\n", $lines), "Markdown", true);
                break;
            case "img":
                $data = $this->img(implode(" ", $message->getData()));
                $id = mt_rand(0, (sizeof($data["items"]) - 1));
                $api->sendPhoto($message->chat->id, $data["items"][$id]["link"], implode(" ", $message->getData()));
                break;
        }
    }


    /*
     * GOOGLE API
     */

    private function search($query) {
        $url = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=";
        $url .= urlencode($query);
        $json = json_decode(file_get_contents($url), true);

        $results = $json["responseData"]["results"];

        return $results;
    }

    private function img($query) {
        $res = $this->gc->query($query, "image", 36000);
        if (!$res) {
            $url = "https://www.googleapis.com/customsearch/v1?imgSize=large&num=10&searchType=image"
             . "&key=". GAPI_KEY ."&cx=".GCSE_ID."&q=";
            $url .= urlencode($query);
            $json = json_decode(file_get_contents($url), true);

            // Save to Cache
            $this->gc->cache($query, $json, "image");

            return $json;
        } else {
            // Cached result found!
            return $res;
        }        
    }

    /*
     * HELPERS
     */

    private static function bToUS($string) {
        return str_replace("<b>", "_", str_replace("</b>", "_", $string));
    }

    private static function encodeUs($string) {
        return str_replace("_", "\\_", $string);
    }

}
?>