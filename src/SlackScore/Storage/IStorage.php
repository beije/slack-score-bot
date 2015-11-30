<?php
    namespace SlackScore\Storage;
    
    interface IStorage {
        public function exists($path);
        
        public function get($path);
        
        public function put($path, $value);
    }