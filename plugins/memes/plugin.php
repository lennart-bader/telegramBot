<?php
    require_once("memes.class.php");

    class Memes {    
        public function execute($data, $message) {
            $cmd = strtolower($data[0]);
            $meme = new MemeApi();
            
            $cmd_params = explode("_", $cmd);
            if (count($cmd_params) > 1) {
                switch ($cmd_params[1]) {
                    case "list":
                        if (count($cmd_params) > 2) {
                            $str = $meme->listMemes($cmd_params[2]);
                        } else {
                            $str = $meme->listMemes();
                        }                    
                        Api::reply($message, $str, true);
                        return;
                        break;
                        
                    case "search":
                        unset($data[0]);
                        $str = $meme->searchMemes($data);
                        Api::reply($message, $str, true);
                        return;
                        break;
                }
            }
            
            $std_meme = "One Does Not Simply";
            $std_text_top = "One Does Not Simply";
            $std_text_bottom = "Use No Parameters";
            
            unset($data[0]);
            $data = implode(" ", $data);
            $args = explode(";", $data);
            
            $num = count($args);
            if ($num == 1 && $args[0] == "") {
                $num = 0;
            }
            
            switch ($num) {
                case 0:
                    $res = $meme->get($std_meme, $std_text_top, $std_text_bottom);                
                    break;
                case 1:
                    $res = $meme->get($args[0], "", "");
                    break;
                case 2:
                    $res = $meme->get($args[0], $args[1], "");
                    break;
                default:
                    $res = $meme->get($args[0], $args[1], $args[2]);
                    break;
            }          
           
            if ($res === false) {
                Api::reply($message, "Huuuups", false);            
            } else {
                $chat = Api::getChat($message);
                Api::sendImg($chat, file_get_contents($res), "meme.jpg");
                //Api::reply($message, $res, false);                
            }
            
        }
    }
?>