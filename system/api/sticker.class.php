<?php
class Sticker {
    public $file_id;
    public $width;
    public $height;
    public $thumb;
    public $file_size;

    public function __construct($b = false) {
        if (is_array($b)) {
            $this->load($b);
        }
    }

    public function load($b) {
        $this->file_id      = $b["file_id"];
        $this->width        = $b["width"];
        $this->height       = $b["height"];
        $this->thumb        = Api::set($b, "thumb", PhotoSize);
        $this->file_size    = Api::pre($b, "file_size", 0);
    }
}
?>