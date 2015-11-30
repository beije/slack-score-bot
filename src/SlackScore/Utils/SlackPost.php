<?php
    namespace SlackScore\Utils;
    
    use SlackScore\Utils\Command;
    use SlackScore\Repository\IUserRepository;
    
    class SlackPost {
        protected $url;
        protected $username;
        protected $channel;
        
        public function __construct($url, $username, $channel) {
            $this->url = $url;
            $this->username = $username;
            $this->channel = $channel;
        }

        public function post($data, $channel = false) {
            $payload = (object) array(
                'channel' => ($channel ? $channel : $this->channel),
                'username' => $this->username,
                'text' => $data
            );
            
            $fields = array(
                'payload' => urlencode(json_encode($payload))
            );
            
            $fields_string = '';
            foreach($fields as $key=>$value) { 
                $fields_string .= $key . '=' . $value . '&'; 
            }
            
            rtrim($fields_string, '&');
            
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $this->url);
            curl_setopt($ch,CURLOPT_POST, count($fields));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
            
            $result = curl_exec($ch);
            
            curl_close($ch);
            
            return $result;
        }
    }
