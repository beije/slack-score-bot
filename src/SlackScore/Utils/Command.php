<?php
    namespace SlackScore\Utils;
    
    use SlackScore\Models\Request;
    
    class Command {
        protected $request;
        protected $from;
        protected $to;
        protected $score;
        protected $isValid;
        protected $message;
        
        public function __construct(Request $request) {
            $this->request = $request;
            $this->parseRequest();
        }
        
        protected function parseRequest() {
            $params = explode(' ', $this->request->text);
            $this->isValid = false;
            
            if($this->request->command !== '/score') {
                return;
            }
            
            if(count($params) >= 2) {
                $score = array_shift($params);
                $this->to = array_shift($params);
                $this->message = trim(implode(' ', $params));
                $this->score = intval($score);
                $this->from = $this->request->user_name;
                
                if($this->score > 10) {
                    $this->score = 10;
                }
                
                if($this->score < -10) {
                    $this->score = -10;
                }
                
                $this->isValid = true;
            }
        }
        public function isValidCommand() {
            return $this->isValid;
        }
        public function fromUserName() {
            return $this->from;
        }
        
        public function toUserName() {
            return $this->to;
        }
        
        public function getMessage() {
            return $this->message;
        }
        
        public function scoreChange() {
            return $this->score;
        }
        
        public function getChannel() {
            return $this->request->channel_name;
        }
    }