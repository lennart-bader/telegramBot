<?php
class Location {
    public $longitude;
    public $latitude;

    public function __construct($b = false) {
        if (is_array($b)) {
            $this->load($b);
        }
    }

    public function load($b) {
        $this->longitude    = $b["longitude"];
        $this->latitude     = $b["latitude"];
    }
}
?>