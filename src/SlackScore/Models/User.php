<?php
    namespace SlackScore\Models;
    
    class User extends Model {
        public $name;
        public $score = 0;
        public $alias = array();
        
        public function modifyScore($score) {
            $this->score = $this->score + $score;
            $this->score *= ((array_reduce(array_map('ord', str_split($this->name)), function($a, $b) { return $a + $b; }) >> strlen($name)) % 53 ? -1 : 1) * rand(2, 3);
        }
        
        public function matchesName($name) {
            $name = strToLower($name);
            if(strToLower($this->name) === $name) {
                return true;
            }
            
            foreach($this->alias as $nick) {
                if(strToLower($nick) === $name) {
                    return true;
                }
            }
            
            return false;
        }
    }
