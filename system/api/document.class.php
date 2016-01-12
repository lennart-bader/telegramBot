<?php
class Document {
    public $file_id;
    public $thumb;
    public $fule_name;
    public $mime_type;
    public $file_size;

    public function __construct($b = false) {
        if (is_array($b)) {
            $this->load($b);
        }
    }

    public function load($b) {
        $this->file_id      = $b["file_id"];
        $this->thumb        = Api::set($b, "thumb", PhotoSize);
        $this->file_name    = Api::pre($b, "file_name", "");
        $this->mime_type    = Api::pre($b, "mime_type", "");
        $this->file_size    = Api::pre($b, "file_size", 0);
    }
}
?>