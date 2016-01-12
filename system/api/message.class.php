<?php
class Message {
    public $id;
    public $from;                       // User
    public $chat;                       // Chat
    public $date;
    public $forward_from;               // User
    public $forward_date;
    public $reply_to_message;           // Message
    
    public $text;
    public $audio;                      // Audio
    public $document;                   // Document
    public $photo;
    public $sticker;                    // Sticker
    public $video;                      // Video
    public $voice;                      // Video 
    public $caption;
    public $contact;                    // Contact
    public $location;                   // Location

    public $new_chat_participant;       // User
    public $left_chat_participant;      // User
    public $new_chat_title;
    public $new_chat_photo;
    public $delete_chat_photo;
    public $group_chat_created;
    public $supergroup_chate_created;
    public $channel_chat_created;
    public $migrate_to_chat_id;
    public $migrate_from_chat_id;
    
    public $type;
    private $data;

    public function __construct($b = false) {
        if ($b != false) {
            $this->load($b);
        }
    }

    public function load($b) {
        $this->data = $b;

        $this->id = $b["message_id"];
        $this->from = Api::set($b, "from", "User");
        $this->date = $b["date"];
        $this->$chat = new Chat($b["chat"]);
        $this->forward_from = Api::set($b, "forward_from", "User");
        $this->forward_date = isset($b["forward_date"]) ? $b["forward_date"] : -1;
        $this->reply_to_message = Api::set($b, "reply_to_message", "Message");

        $this->type = $this->getType();
    }

    private function getType() {
        $b = $this->data;
        if (isset($b["text"])) {
            $this->text = $b["text"];
            $this->type = "text";
        
        } elseif (isset($b["audio"])) {
            $this->audio = new Audio($b["audio"]);
            $this->type = "audio";            
        
        } elseif (isset($b["document"])) {
            $this->document = new Document($b["document"]);
            $this->type = "document";            
        
        } elseif (isset($b["photo"])) {
            $this->photo = new PhotoArray($b["photo"]);
            $this->type = "photo";            
        
        } elseif (isset($b["sticker"])) {
            $this->sticker = new Sticker($b["sticker"]);
            $this->type = "sticker";            
        
        } elseif (isset($b["video"])) {
            $this->video = new Video($b["video"]);
            $this->type = "video";            
        
        } elseif (isset($b["voice"])) {
            $this->voice = new Voice($b["voice"]);
            $this->type = "voice";            
        
        } elseif (isset($b["contact"])) {
            $this->contact = new Contact($b["contact"]);
            $this->type = "contact";            
        
        } elseif (isset($b["location"])) {
            $this->location = new Location($b["location"]);
            $this->type = "location";            
        
        } elseif (isset($b["new_chat_participant"])) {
            $this->new_chat_participant = new User($b["new_chat_participant"]);
            $this->type = "new_chat_participant";            
        
        } elseif (isset($b["left_chat_participant"])) {
            $this->left_chat_participant = new User($b["left_chat_participant"]);
            $this->type = "left_chat_participant";            
        
        } elseif (isset($b["new_chat_title"])) {
            $this->new_chat_title = $b["new_chat_title"];
            $this->type = "new_chat_title";            
        
        } elseif (isset($b["new_chat_photo"])) {
            $this->new_chat_photo = new PhotoArray($b["new_chat_photo"]);
            $this->type = "new_chat_photo";            
        
        } elseif (isset($b["new_chat_photo"])) {
            $this->new_chat_photo = true;
            $this->type = "new_chat_photo";            
        
        } elseif (isset($b["group_chat_created"])) {
            $this->group_chat_created = true;
            $this->type = "group_chat_created";            
        
        } elseif (isset($b["supergroup_chat_created"])) {
            $this->supergroup_chat_created = true;
            $this->type = "supergroup_chat_created";            
        
        } elseif (isset($b["channel_chat_created"])) {
            $this->channel_chat_created = true;
            $this->type = "channel_chat_created";            
        
        } elseif (isset($b["migrate_to_chat_id"])) {
            $this->migrate_to_chat_id = $b["migrate_to_chat_id"];
            $this->type = "migrate_to_chat_id";            
        
        } elseif (isset($b["migrate_from_chat_id"])) {
            $this->migrate_from_chat_id = $b["migrate_from_chat_id"];
            $this->type = "migrate_from_chat_id";            
        }
        if (isset($b["caption"])) {
            $this->caption = $b["caption"];
        }
    }
}
?>