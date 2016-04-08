<?php
    namespace SlackScore\Repository;
    
    class SlackUserRepository implements \SlackScore\Repository\IUserRepository {
        const END_POINT = 'https://slack.com/api/users.list';
        protected $token = '';
        protected $users = [];
        protected $loaded = false;
        
        public function __construct($token) {
            $this->token = $token;
            
            // If no token has been given, assume that it has been loaded.
            if($this->token) {
                $this->load();
            }
        }
        
        protected function load() {
            
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, self::END_POINT . '?token=' . $this->token);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
            
            $response = json_decode(curl_exec($ch));
            
            curl_close($ch);
            
            if(!$response->ok) {
                throw new \Exception('Could not fetch users: '. $response->error);
            }
            
            $this->loaded = true;
            $this->users = $response->members;
        }
        
        public function hasLoaded() {
            return $this->loaded;
        }
        
        
        public function getUsers() {
            return $this->users;
        }
        
        public function getByName($username) {
            $username = str_replace('@', '', $username);

            $result = array_filter($this->users, function($user) use ($username) { return ($username == $user->name); }); 
            
            return current($result);
        }
        
        public function addUser($name, $aliases = [], $score) {
            // Not applicable
        }
        
        public function save() {
            // Not applicable
        }
    }
    