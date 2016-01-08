<?php
class Hello {
    public function execute($data, $message) {
        // This does nothing for now
    }

    public function receive($data, $message) {
        $this->greetings($data, $message);
        $this->lennartHatRecht($data, $message);
    }

    private function greetings($data, $message) {
        $text = implode(" ", $data);
        $keywords = array(
            "hallo", "guten morgen", "guten tag", "guten abend", "gute nacht", "moin", "salve", "hi", "huhu", "nabend", "grützi"
            );

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
                    case "moin":
                        $api->sendMessage($chatid, "Moin! :)");
                        break;
                    case "gute nacht":
                        $h = date("H");
                        if ($h >= 21 && $h < 7) {
                            
                        }
                        break;
                    default:
                        $h = date("H");
                        if ($h <= 4) {
                            $msg = "So spät noch wach, " . $name . "?";
                        } elseif ($h <= 5) {
                            $msg = "Du bist aber früh auf, " . $name . "...";
                        } elseif ($h <= 11) {
                            $msg = "Guten Morgen, " . $name . "!";
                        } elseif ($h <= 18) {
                            $msg = "Hallo " . $name . "!";
                        } elseif ($h <= 23) {
                            $msg = "Guten Abend " . $name . "!";
                        }
                        $api->sendMessage($chatid, $msg);
                        break;
                }
                break;
            }            
        }
    }

    private function lennartHatRecht($data, $message) {
        $text = strtolower(implode(" ", $data));
        global $api;
        global $chatid;
        if (strpos("jarvis sag doch auch mal was", $text) === 0) {
            if ($message["message"]["from"]["username"] == "kryptur") {
                $array = array("Lennart hat Recht!", "Ich sehe das wie Lennart.", "Ich stimme dir voll zu", "Sehe ich auch so");
                $msg = $array[array_rand($array)];
                $api->sendMessage($chatid, $msg);                
            } else {
                $array = array("Frag doch mal Lennart, der hat bestimmt Recht!", "Was soll ich da sagen?", 
                    "Hmmmmm");
                $msg = $array[array_rand($array)];
                $api->sendMessage($chatid, $msg); 
            }
        }
    }
}