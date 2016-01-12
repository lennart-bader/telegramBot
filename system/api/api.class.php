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
}
?>