<?php
    namespace SlackScore\Models;
    
    class Request extends Model {
        public $token;
        public $team_id;
        public $team_domain;
        public $channel_id;
        public $channel_name;
        public $timestamp;
        public $user_id;
        public $user_name;
        public $text;
        public $command;
        
        public function __construct($data) {
            foreach($this as $key => $value) {
                if(isset($data[$key])) {
                    $this->$key = $data[$key];
                }
            }
        }
    }