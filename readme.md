# Slack score bot

This is a simple bot that just keeps track of scoring for different users.

## Installation

Installation is pretty straightforward, you need to have access to the slack integration parts, and your server needs PHP with curl.

### Server
You'll need a server with php. (And it needs curl)

1. Clone the repo anywhere on the server
2. Copy the `/config.example.php` to `config.php` and edit it with the correct values for your slack
3. Add an empty file in `data/users.json`, this is the datastore for all the scores and users.
4. Point your webserver to the `/public/` folder.

### Slack

1. Add an `incoming webhook`, copy the webhook url to the `config.php`.
2. Add a `Slack command` called `/score` and point the command to your server.

## Commands

* `/score list` will output a list with current score for all users (it will only be visible for the user issuing the command, it will *not* be visible in the channel).
* `/score [int] [str]` adds score `int` to user `str` (_/score -1 fooBar_ removes one point from user _fooBar_), this command will issue an output to the _#general_ channel. If the user `str` doesn't exist, a new one will be created with that name.
* `/score [int] [str] [str]` same as previous, but the second string will be used instead of the phrases, the custom message will be outputted as _@from: custom message (@foobar -1)_

## Users.json

The `/data/users.json` file is just a json file with an array of objects, each object represents a user.

    [
        {
            "name": "fooBar", // The slack name
            "score": -5, // The current score
            "alias": [ // additional names that this user should respond to
                "foo bar",
                "foo",
                "bar"
            ]
        }
    ]

You can change the location of the user file in the `/config.php`
    
# Credits

* The IOC is powered by [Dice](https://r.je/dice.html)