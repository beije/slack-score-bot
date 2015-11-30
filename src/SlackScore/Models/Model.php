<?php
    namespace SlackScore\Models;
    
    class Model {
        public function toJson() {
            return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
        }
    }