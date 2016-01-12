<?php
class File {
    public $file_id;
    public $file_size;
    public $file_path;

    public function __construct($b = false) {
        if (is_array($b)) {
            $this->load($b);
        }
    }

    public function load($b) {
        $this->file_id      = $b["file_id"];
        $this->file_size    Api::pre($b, "file_size", 0);
        $this->file_path    Api::pre($b, "file_path", "");
    }
}
?>