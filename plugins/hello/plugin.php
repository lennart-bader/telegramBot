<?php
class Hello {
    public function execute($data, $message) {
        // This does nothing for now
    }

    public function receive($data, $message) {
        $this->greetings($data, $message);
    }

    private function greetings($data, $message) {
        global $t;
        $t->setPlugin("hello");

        $text = implode(" ", $data);
        // Load keywords from language file
        $keywords = $t->g("keywords");

        global $api;
        global $chatid;

        $text = strtolower($text);
        foreach ($keywords as $keyword) {
            $sender = $message["message"]["from"];
            if ($sender["first_name"] == "") {
                $name = $sender["username"];
            } else {
                $name = $sender["first_name"];
            }
            
            preg_match_all('/\b' . $keyword . '\b/', $text, $matches, PREG_OFFSET_CAPTURE);


            if (sizeof($matches[0]) > 0 && is_array($matches[0][0]) && sizeof($matches[0][0]) > 0) {
                switch ($keyword) {
                    // Moin / Hi
                    case $keywords[5]:
                        $api->sendMessage($chatid, ucwords($keywords[5]) . " :)");
                        break;
                    // Good night
                    case $keywords[4]:
                        $h = date("H");
                        if ($h >= 21 && $h < 7) {
                            $texts = $t->g("good_night");
                            $num = mt_rand(0, sizeof($texts) - 1);
                            $api->sendMessage($chatid, sprintf($texts[$num], $name));
                        } else {
                            $texts = $t->g("no_night_time");
                            $num = mt_rand(0, sizeof($texts) - 1);
                            $api->sendMessage($chatid, sprintf($texts[$num], $name));
                        }
                        break;
                    default:
                        $h = date("H");
                        if ($h <= 4) {
                            $texts = $t->g("nighthawk");
                        } elseif ($h <= 5) {
                            $texts = $t->g("early_bird");
                        } elseif ($h <= 11) {
                            $texts = $t->g("good_morning");
                        } elseif ($h <= 18) {
                            $texts = $t->g("hello");
                        } elseif ($h <= 23) {
                            $texts = $t->g("good_night");
                        }
                        $num = mt_rand(0, sizeof($texts) - 1);
                        $msg = sprintf($texts[$num], $name);
                        $api->sendMessage($chatid, $msg);
                        break;
                }
                break;
            }            
        }
    }
}