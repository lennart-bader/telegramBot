<?php
 
class MemeApi {
    private $login_name = meme_api_login;
    private $login_pw = meme_api_pw;
    private $list_url = "https://api.imgflip.com/get_memes";
    private $img_url = "https://api.imgflip.com/caption_image";
    
    private $std_meme = "One Does Not Simply";
    private $std_text_top = "One Does Not Simply";
    private $std_text_bottom = "Use Wrong Parameters";
                       
    
    public function __construct() {
        global $t;
        $t->setPlugin("memes");
    }
    
    public function get($name, $top, $bottom) {
        $img = $this->nameToImg($name);
        if (!$img["id"]) {
            $name = $this->std_meme;
            $top = $this->std_text_top;
            $bottom = $this->std_text_bottom;
            file_put_contents("log/memes.log", $name);
            $img = $this->nameToImg($name);
            if (!$img["id"]) {
                return false;
            }
        }
        
        if ($top == "" && $bottom == "")
            return $img["url"];
        
        return $this->captionImg($img["id"], $top, $bottom);
        
        //return $img["url"];
    }
    
    public function listMemes($count = 30) {
        global $t;
        $res = json_decode(file_get_contents($this->list_url), true);
        if ($res["success"]) {
            $memes = $res["data"]["memes"];
            if (is_array($memes)) {
                $result = array();
                foreach ($memes as $meme) {
                    if ($count == 0)
                        break;
                    $count--;
                    $result[] = $meme["name"];
                }
            }
            $str = implode("\n", $result);
            $str = "*" .$t->g("possible_memes") . "*:\n" . $str;
            return $str;
        } else {
            return $t->g("notfound");
        }
    }
    
    public function searchMemes($search) {
        global $t;
        $res = json_decode(file_get_contents($this->list_url), true);
        if ($res["success"]) {
            $memes = $res["data"]["memes"];
            if (is_array($memes)) {
                $result = array();
                foreach ($memes as $meme) {
                    $add = true;
                    file_put_contents("log/memes.log", implode(";", $search));
                    foreach ($search as $name) {
                        if (strpos(strtolower($meme["name"]), strtolower($name)) === false) {
                            $add = false;
                        }
                    }
                    if ($add) {                        
                        $result[] = $meme["name"];
                    }                   
                }
            }
            $str = implode("\n", $result);
            $str = "*" .$t->g("found") . "*:\n" . $str;
            return $str;
        } else {
            return $t->g("notfound");
        }
    }
    
    private function nameToImg($name) {
        $res = json_decode(file_get_contents($this->list_url), true);
        $res["id"] = false;
        $res["url"] = false;
        if ($res["success"]) {
            $memes = $res["data"]["memes"];
            if (is_array($memes)) {
                foreach ($memes as $meme) {
                    if (strpos(strtolower($meme["name"]), strtolower($name)) !== false) {
                        $res["id"] = $meme["id"];
                        $res["url"] = $meme["url"];
                        break;
                    }
                }
            }
        }       
        return $res;
    }
    
    private function captionImg($id, $top, $bottom) {
        $data = array(
            'username' => $this->login_name,
            'password' => $this->login_pw,
            'template_id' => $id,
            'text0' => $top,
            'text1' => $bottom);

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($this->img_url, false, $context);

        $res = json_decode($result, true);
        if ($res["success"]) {
            return $res["data"]["url"];
        } else {
            return $res["error_message"];
        }
    }
}
    
    
?>
