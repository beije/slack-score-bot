<?php
    namespace SlackScore\Utils;
    
    
    class ScoreBoard {
        public static function render($users) {
            $output = '';
            foreach(usort($users, function($a, $b) { return $a->score == $b->score ? 0 : ($a->score < $b->score ? 1 : -1); }) as $user) {
                $output .= '@' . $user->name . ' = ' . $user->score . "\n";
            }
            
            return $output;
        }
    }
