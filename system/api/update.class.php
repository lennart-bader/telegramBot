<?php
class Update {
    public $id;             // int
    public $message;        // Message
    public $inline_query;   // InlineQuery
    public $type;

    public function __construct($build = false) {
        if ($build !== false) {
            $this->id = $build["update_id"];
            if (isset($build["message"])) {
                $this->message = new Message($build["message"]);
                $this->type = "message";
            } else {
                // TODO: InlineQueries
                $this->type = "inlineQuery";
            }
        }
    }
}
?>