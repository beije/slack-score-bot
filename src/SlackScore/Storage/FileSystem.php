<?php
    namespace SlackScore\Storage;
    
    class FileSystem implements IStorage {
        public function exists($path) {
            return file_exists($path);
        }
        
        public function get($path) {
            if ($this->exists($path)) {
                return file_get_contents($path);
            }
        }
        
        public function put($path, $value) {
            $fstream = fopen($path, "w");
            $result = fwrite($fstream, $value);
            fclose($fstream);
            
            return $result;
        }
    }