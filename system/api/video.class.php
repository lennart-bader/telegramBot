<?php
class Video {
    public $file_id;
    public $width;
    public $height;
    public $duration:
    public $thumb;
    public $mime_type;
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
        $this->duration     = $b["duration"];
        $this->thumb        = Api::set($b, "thumb", PhotoSize);
        $this->mime_type    = Api::pre($b, "mime_type", "");
        $this->file_size    = Api::pre($b, "file_size", 0);
    }
}
?>