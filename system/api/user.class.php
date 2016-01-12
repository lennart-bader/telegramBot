<?php
class User {
    public $id;
    public $first_name;
    public $last_name;
    public $username;

    public function __construct($b = false) {
        if (is_array($b)) {
            $this->load($b);
        }
    }

    public function load($b) {
        $this->id           = $b["id"];
        $this->first_name   = $b["first_name"];
        $this->last_name    = Api::pre($b, "last_name", "");
        $this->username     = Api::pre($b, "username", "");
    }
}
?>