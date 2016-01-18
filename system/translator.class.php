<?php
/* This class provides simple translation possibilities.
 * Plugins may use language files to automatically translate their texts
 */

class Translator {
    private $plugin;
    private $data;
    private $available;

    public function __construct() {
        $this->available = false;
    }

    public function getLanguage() {
        return strtolower(LANGUAGE);
    }

    public function usedLanguage() {
        if ($this->available) {
            return strtolower(LANGUAGE);
        } else {
            return strtolower(DEFAULT_LANGUAGE);
        }

    }

    public function setPlugin($plugin) {
        $this->plugin       = $plugin;
        $file = "plugins/".$plugin."/lang.json";
        if (file_exists($file)) {
            $this->data = $this->load($file);
            $this->available = true;
        } else {
            error_log($plugin . "-help not available");
            $this->available = false;
        }
    }


    // Short form for getText
    public function g($source, $lang = LANGUAGE) {
        return $this->getText($source, $lang);
    }


    public function getText($text, $lang) {
        $lang = strtolower($lang);
        if (isset($this->data[$text][$lang])) {
            return $this->data[$text][$lang];
        } elseif (isset($this->data[$text][DEFAULT_LANGUAGE])) {
            return $this->data[$text][DEFAULT_LANGUAGE];
        } else {
            return $text;
        }
    }

    

    private function load($file) {
        $data = file_get_contents($file);
        $data = json_decode($data, true);
        return $data;
    }
}
?>