<?php
class Hello {
    public function execute($message) {
        // This does nothing for now
    }

    public function receive($message) {
        $this->greetings($message);
    }

    private function greetings($message) {
        global $t;
        $t->setPlugin("hello");

        $text = $message->text;
        // Load keywords from language file
        $keywords = $t->g("keywords");

        global $api;

        $text = strtolower($text);
        foreach ($keywords as $keyword) {
            $name = $message->from->first_name;
            
            preg_match_all('/\b' . $keyword . '\b/', $text, $matches, PREG_OFFSET_CAPTURE);


            if (sizeof($matches[0]) > 0 && is_array($matches[0][0]) && sizeof($matches[0][0]) > 0) {
                switch ($keyword) {
                    // Moin / Hi
                    case $keywords[5]:
                        $api->sendMessage($message->chat->id, ucwords($keywords[5]) . " :)");
                        break;
                    // Good night
                    case $keywords[4]:
                        $h = date("H");
                        if ($h >= 21 && $h < 7) {
                            $texts = $t->g("good_night");
                            $num = mt_rand(0, sizeof($texts) - 1);
                            $api->sendMessage($message->chat->id, sprintf($texts[$num], $name));
                        } else {
                            $texts = $t->g("no_night_time");
                            $num = mt_rand(0, sizeof($texts) - 1);
                            $api->sendMessage($message->chat->id, sprintf($texts[$num], $name));
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
                            $texts = $t->g("good_evening");
                        }
                        $num = mt_rand(0, sizeof($texts) - 1);
                        $msg = sprintf($texts[$num], $name);
                        $api->sendMessage($message->chat->id, $msg);
                        break;
                }
                break;
            }            
        }
    }
}