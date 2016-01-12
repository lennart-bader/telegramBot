<?php
/* This class provides simple translation possibilities.
 * Plugins may use language files to automatically translate their texts
 */

class Translator {
    private $plugin;
    private $data;
    private $default_data;
    private $available;
    private $default_available;

    public function __construct() {
        $this->available = false;
    }

    public function loadPlugin($plugin) {
        $this->plugin       = $plugin;
        $file1              = "plugins/" . $plugin . "/language/" . strtolower(LANGUAGE);
        $file2              = "plugins/" . $plugin . "/language/en";

        if (!file_exists($file2)) {
            $this->default_available = false;
        } else {
            $this->default_data = explode("\n", file_get_contents($file2));
            $this->default_available = true;
        }

        if (!file_exists($file2)) {
            $this->available = false;
        } else {
            $this->available = true;
            $this->data         = explode("\n", file_get_contents($file1));
        }
    }


    // Short form for getText
    public function g($source, $isText = false) {
        return $this->getText($source, $isText);
    }

    
    public function getText($source, $isText = false) {
        if ($isText) {
            return $this->getTextFromText($source);
        } else {
            return $this->getTextFromLine($source);
        }
    }


    // Tries to return the text by translation.
    private function getTextFromText($text) {
        if ($this->default_available) {
            $line = array_search($text, $this->default_data);
            if ($line !== false) {
                return $this->getTextFromLine($line);
            }
        }
        
        // No data available, return given text
        return $text;
    }

    // Tries to return the text from the specified line
    private function getTextFromLine($line) {
        if ($this->available && sizeof($this->data) > $line) {
            return $this->data[$line];
        } elseif ($this->default_available && sizeof($this->default_data) > $line) {
            return $this->default_data[$line];
        } else {
            return "Cannot find any matching text for id #".$line;
        }
    }
}
?>