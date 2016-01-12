<?php
class Chat {
    public $id;
    public $type;
    public $title;
    public $username;
    public $first_name;
    public $last_name;

    public function __construct($b = false) {
        if (is_array($b)) {
            $this->load($b);
        }
    }

    public function load($b) {
        $this->id           = $b["id"];
        $this->type         = $b["type"];
        $this->title        = Api::pre($b, "title", "");
        $this->username     = Api::pre($b, "username", "");
        $this->first_name   = Api::pre($b, "first_name", "");
        $this->last_name    = Api::pre($b, "last_name", "");
    }
}
?>