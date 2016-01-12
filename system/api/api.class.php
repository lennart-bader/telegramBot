<?php
class Api {
    public static function set($data, $key, $type) {
        if (isset($data[$key])) {
            return new $type($data[$key]);
        } else {
            return new EmptyKey($type);
        }
    }

    public static function pre($data, $key, $default) {
        if (isset($data[$key])) {
            return $data[$key];
        } else {
            return $default;
        }
    }

    public static function reply($chat, $text, $parse_mode = null) {
        global $api;
        file_put_contents("log/api.log", $text);
        if ($parse_mode) {
            $pm = "Markdown";
        } else {
            $pm = null;
        }
        $api->sendMessage($chat->id, $text, $pm);
    }

    public static function encodePlain($text) {
        return str_replace("_", "\\_", 
            str_replace("*", "\\*", 
            str_replace("=", "\\=",
            $text)));
    }
}
?>