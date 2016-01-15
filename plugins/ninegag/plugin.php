<?php
class NineGag {
    public function execute($message) {
        global $api;

        // $data = $this->getImage();
        // $api->sendPhoto($message->chat->id, $data[0], $data[1]);

        $data = $this->parsePage();
        $id = mt_rand(0, (sizeof($data) - 1));
        $api->sendPhoto($message->chat->id, $data[$id]["img"], $data[$id]["title"]);

    }

    private function getImage() {
        $url = "http://api-9gag.herokuapp.com/";
        $data = json_decode(file_get_contents($url), true);
        $id = mt_rand(0, (sizeof($data) - 1));
        $src = $data[$id]["src"];
        $title = $data[$id]["title"];
        if (substr($src, 0, 2) == "//") {
            $src = substr($src, 2);
        }
        return array($src, $title);
    }

    private function parsePage($page = "trending") {
        $html = file_get_contents("http://9gag.com/" . $page);
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        $entries = $doc->getElementsByTagName('article');
        $results = array();
        foreach ($entries as $entry) {
            $id = $entry->getAttribute("data-entry-id");
            $url = "http://img-9gag-fun.9cache.com/photo/" . $id . "_460s.jpg";

            $res = array(
                "id" => $id,
                "img" => $url,
                "title" => trim($entry->firstChild->textContent)
                );
            $results[] = $res;
        }
        return $results;
    }

}
?>