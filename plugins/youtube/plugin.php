<?php
class Youtube {
    public function execute($data, $message) {
        // This does nothing for now
        switch ($data[0]) {
        case "dlv":
            global $api;
            global $chatid;
            $api->sendVideo($chatid, $data[1]);
            break;
        }
    }

    public function receive($data, $message) {
        // Check if message is Youtube-URL
        $text = implode(" ", $data);
        if (filter_var($text, FILTER_VALIDATE_URL)) {
            // Expand shortened URLs
            $url = $this->expand_url($text);


            if (strpos($url, "youtube") !== false) {
                $file = $this->download($url, $message);
                if ($file != false) {                    
                    $id = $this->urlToId($url);
                    global $api;
                    global $chatid;
                    $api->sendVideo($chatid, $file);
                }
            } elseif (substr($url, -4) == ".mp4") { // DL and send mp4 videos
       		global $api;
	        global $chatid;
       		$api->sendVideo($chatid, $text);
       	    }
        }
    }

    private function download($url, $message) {
        $id = $this->urlToId($url);

        if ($id === false) {
            return false;
        }

        $type = "video/mp4";

        parse_str(file_get_contents('http://www.youtube.com/get_video_info?video_id='.$id),$info); 
        $streams = explode(',',$info['url_encoded_fmt_stream_map']); 

        foreach($streams as $stream){ 
            parse_str($stream, $real_stream); 
            $stype = $real_stream['type']; 
            
            if(strpos($real_stream['type'],';') !== false){ 
                $tmp = explode(';',$real_stream['type']); 
                $stype = $tmp[0]; 
                unset($tmp); 
            } 
            if($stype == $type && ($real_stream['quality'] == 'large' || $real_stream['quality'] == 'medium' || $real_stream['quality'] == 'small')){ 
                //Api::reply($message, "Type: " .  $stype . "\nURL:\n" . $real_stream["url"]);
                return $real_stream['url'];
                break; 
            } 
        }

        return false;
    }

    private function urlToId($url) {
        $a = explode("?", $url);
        $var_area = $a[1];
        $assignments = explode("&", $var_area);
        foreach ($assignments as $assignment) {
            $split = explode("=", $assignment);
            if ($split[0] == "v") {
                unset($split[0]);
                $val = implode("=", $split);
                return $val;
            }
        }
        return false;
    }

    private function expand_url($url){
        //Get response headers
        $response = get_headers($url, 1);
        //Get the location property of the response header. If failure, return original url
        if (array_key_exists('Location', $response)) {
            $location = $response["Location"];
            if (is_array($location)) {
                // t.co gives Location as an array
                return $this->expand_url($location[count($location) - 1]);
            } else {
                return $this->expand_url($location);
            }
        }
        return $url;
    }
}
