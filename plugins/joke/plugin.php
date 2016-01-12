<?php
class Joke {
    public function execute($message) {
        $joke = file_get_contents("http://www.witzcharts.de/witz.php?witz=zufall");
        $joke = str_replace('document.write("', "", $joke);
        $joke = str_replace("<br><a href='http://www.witzcharts.de' target='_blank'>witzcharts.de</a>\");", "", $joke);
        $joke = str_replace("<br />", "\n", $joke);
        $joke = html_entity_decode($joke);
        
        Api::reply($message->chat, $joke);
    }
}
?>