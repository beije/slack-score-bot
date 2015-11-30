<?php
    namespace SlackScore\Repository;
        
    interface IUserRepository {
        public function getByName($username);
        public function addUser($name, $aliases = [], $score);
        public function save();
    }
?>