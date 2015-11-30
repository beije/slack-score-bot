<?php 

$config = array(
	'posturl' => '',
    'username' => 'scoreBot',
    'channel' => '#general',
    'users' => realpath(dirname(__FILE__)) . '/data/users.json',
   
    'phrases' => [
        'positive' => [
            ':from hugged :to with :score points'
        ],
        'negative' => [
            ':from slapped :to in the face with a :score reduction'
        ]
    ]
);
	