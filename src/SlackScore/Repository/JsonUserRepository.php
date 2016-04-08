<?php
    namespace SlackScore\Repository;
    
    class JsonUserRepository implements \SlackScore\Repository\IUserRepository {
        private $storage;
        private $path;
        protected $users = [];
        
        private function compareScore($a, $b) {
            return $b->score - $a->score;
        }
        
        public function __construct($path, \SlackScore\Storage\IStorage $storage) {
            $this->path = $path;
            $this->storage = $storage;
            $this->load();
        }
        
        public function load() {
            $file = $this->storage->get($this->path);
            
            if(!$file) {
                $users = [];
                
                return;
            }
            
            $json = json_decode($file);
            
            foreach($json as $userObject) {
                $this->addUser($userObject->name, $userObject->alias, $userObject->score);
            }
            
            usort($this->users, array($this, 'compareScore'));
        }
        
        public function getByName($name) {
            foreach($this->users as $user) {
                if($user->matchesName($name)) {
                    return $user;
                }
            }
            
            return false;
        }
        public function getUsers() {
            return $this->users;
        }
        public function addUser($name, $aliases = [], $score) {
            if($this->getByName($name)) {
                return $this->getByName($name);
            }
            
            $user = new \SlackScore\Models\User();
            $user->name = $name;
            $user->score = $score;
            $user->alias = $aliases;
            
            $this->users[] = $user;
        }
        
        public function save() {
            $file = $this->storage->put($this->path, json_encode($this->users, JSON_PRETTY_PRINT));
        }
    }
?>