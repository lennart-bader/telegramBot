<?php
class Contact {
    public $phone_number;
    public $first_name;
    public $last_name;
    public $user_id;

    public function __construct($b = false) {
        if (is_array($b)) {
            $this->load($b);
        }
    }

    public function load($b) {
        $this->phone_number = $b["phone_number"];
        $this->first_name   = $b["first_name"];
        $this->last_name    = Api::pre($b, "last_name", "");
        $this->user_id      = Api::pre($b, "user_id", 0);
    }
}
?>