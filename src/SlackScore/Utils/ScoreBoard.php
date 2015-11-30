<?php
    namespace SlackScore\Utils;
    
    
    class ScoreBoard {
        public static function render($users) {
            $output = '';
            foreach($users as $user) {
                $output .= '@' . $user->name . ' = ' . $user->score . "\n";
            }
            
            return $output;
        }
    }