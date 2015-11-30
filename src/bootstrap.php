<?php
error_reporting(-1);
    include_once(realpath(dirname(__FILE__)) . '/autoloader.php');
    require_once(realpath(dirname(__FILE__)) . '/../vendor/Dice/Dice.php');
    require_once(realpath(dirname(__FILE__)) . '/../config.php');
    
    autoloader::init();
    
    $dice = new \Dice\Dice;
    
    $dice->addRule(
        '\SlackScore\Models\Request', 
        [
            'shared'          => true,
            'constructParams' => [$_REQUEST]
        ]
    );
    
    $dice->addRule(
        '\SlackScore\Utils\SlackPost', 
        [
            'shared'          => true,
            'constructParams' => [$config['posturl'], $config['username'], $config['channel']]
        ]
    );
    
    $dice->addRule(
        '\SlackScore\Repository\JsonUserRepository', 
        [
            'shared'          => true,
            'constructParams' => [$config['users']],
            'substitutions' => ['SlackScore\Storage\IStorage' => ['instance' => '\SlackScore\Storage\FileSystem']]
        ]
    );

    
    $dice->addRule(
        '\SlackScore\Utils\Comeback', 
        [
            'constructParams' => [$config['phrases']],
            'substitutions' => [
                'SlackScore\Repository\IUserRepository' => ['instance' => '\SlackScore\Repository\JsonUserRepository']
            ]
        ]
    );
    
    $dice->addRule(
        '\SlackScore\Main', 
        [
            'substitutions' => [
                'SlackScore\Repository\IUserRepository' => ['instance' => '\SlackScore\Repository\JsonUserRepository']
            ]
        ]
    );
    