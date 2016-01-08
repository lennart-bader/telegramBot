<?php
    class Api {
        public static function setWebhook($url) {
            return file_get_contents(TELEGRAM_API . "setWebhook?url=" . $url);
        }
        
        public static function getUpdate() {
            return json_decode(file_get_contents("php://input"), true);
        }
        
        public static function reply($chat, $msg, $markdown = false) {
            if (isset($chat["message"])) {
                $chatid = $chat["message"]["chat"]["id"];
				if ($markdown) {
					$pm = "&parse_mode=Markdown";
				} else {
					$pm = "";
				}
                file_get_contents(TELEGRAM_API . "sendMessage?chat_id=" . $chatid . "&text=".urlencode($msg).$pm);
                return true;
            } else {
                return false;
            }
        }

        public static function encodePlain($text) {
            return str_replace("_", "\\_", 
                str_replace("*", "\\*", 
                str_replace("=", "\\=",
                $text)));
        }
        
        public static function getChat($message) {
             $chatid = $message["message"]["chat"]["id"];
             return $chatid;
        }
        
        
        
        public static function sendImg($chat, $img, $path) {
            Api::postFileToUrl(TELEGRAM_API . "sendPhoto?chat_id=" . $chat, "photo", "image/jpg", $path, $img);
        }


        public static function sendVideo($chat, $file, $path) {
            return Api::postFileWithCurl(TELEGRAM_API . "sendVideo?chat_id=" . $chat, "video", "video/mp4" , $path, $file);
        }
        
        private static function postFileToUrl($url, $name, $type, $file, $data) {
            define('FORM_FIELD', $name);
            define('MULTIPART_BOUNDARY', '--------------------------'.microtime(true));
            $header = 'Content-Type: multipart/form-data; boundary='.MULTIPART_BOUNDARY;
            $filename = $file;
            $file_contents = $data;    
            

            $content =  "--".MULTIPART_BOUNDARY."\r\n".
                        "Content-Disposition: form-data; name=\"".FORM_FIELD."\"; filename=\"".$filename."\"\r\n".
                        "Content-Type: ".$type."\r\n\r\n".
                        $file_contents."\r\n";
                        
            $content .= "--".MULTIPART_BOUNDARY."--\r\n";
            
            $context = stream_context_create(array(
                'http' => array(
                      'method' => 'POST',
                      'header' => $header,
                      'content' => $content,
                )
            ));
            
            file_get_contents($url, false, $context);      
        }

        private static function postFileWithCurl($url, $name, $type, $file, $data) {            
            $header = array('Content-Type: multipart/form-data', "Content-Type: ".$type);
            $fields = array($name => new CurlFile($file));
             
            $resource = curl_init();
            curl_setopt($resource, CURLOPT_URL, $url);
            curl_setopt($resource, CURLOPT_HTTPHEADER, $header);
            curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($resource, CURLOPT_POST, 1);
            curl_setopt($resource, CURLOPT_POSTFIELDS, $fields);
            $result = curl_exec($resource);
            curl_close($resource);
            return $result;
        }
    }
?>
