<?php 
/*
 * Copy this file to config.php and set the correct values.
 *
 */
$config = array(
    /* Incoming webhook url */
	'posturl' => '',
    
    /* Name the bot should post as */
    'username' => 'scoreBot',
    
    /* Channel the bot should post in */
    'channel' => '#general',
    
    /* Slack command token, leave empty or set to false if you don't want to check the incoming values */
    'token' => '',
    
    /* Bot token, if you leave this empty, user names won't be checked with slack */
    'botToken' => '',
    
    /* Where the JSON file with the user data is stored */
    'users' => realpath(dirname(__FILE__)) . '/data/users.json',
   
    /* Phrases that the bot should post in #general when score is added/removed 
     * :from - the one who issued the command
     * :to - the user targeted
     * :score - the score command -1/+1 */
    'phrases' => [
        
        // If score is added, random from this list
        'positive' => [
            ':from hugged :to with :score points'
        ],
        
        // If score is reduced, random from this list
        'negative' => [
            ':from slapped :to in the face with a :score reduction'
        ]
    ]
);
	