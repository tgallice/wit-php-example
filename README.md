Wit.ai php demo
===============

This is an interactive demo using the [tgallice/wit-php][1] sdk.

- You should create a [wit.ai][2] account before run the demo.
- Make sure to install dependencies with composer before 
running the demo.

All these demos are built with the [symfony/console][3] component and should be used with a CLI.

Install
-------
```bash

$ git clone git@github.com:tgallice/wit-php-example.git
$ cd wit-php-example
$ composer install

```

Quickstart demo
---------------

It's based on the quickstart tutorial of wit.ai which can be found [here][4]

```bash
$ php demo.php wit:quickstart <access_token>
>>> What is the weather ?           
+ Action : getForecast
+++ Where exactly?
>>> In London
+ Action : getForecast
+ Entities provided:
{
    "location": [
        {
            "confidence": 0.99930685842002,
            "type": "value",
            "value": "London",
            "suggested": true
        }
    ]
}

+ Say : The weather will be sunny in London
+++ The weather will be sunny in London
+ Stop

```

Intent by text
--------------

This command provides an easy way to extract meaning based on message input.

```bash
$ php demo.php wit:message <access_token>
>>> I live in London
+ Response body :
{
    "msg_id": "e8cca629-cf2a-445a-b1c8-7bd1d569330e",
    "_text": "I live in London",
    "entities": {
        "location": [
            {
                "confidence": 0.99984823481825,
                "type": "value",
                "value": "London",
                "suggested": true
            }
        ]
    }
}
>>> 

```

Intent by speech
----------------

You can test to extract meaning by speech. A sample is provided, but you can use your own.

```bash
$ php demo.php wit:speech <access_token>
File path >>> sample/sample.mp3   
+ Please wait...
+ Response body :
{
    "msg_id": "702657bc-5672-444e-a0cc-5a673306aa8b",
    "_text": "hello i live in london",
    "entities": {
        "location": [
            {
                "confidence": 0.99984823481825,
                "type": "value",
                "value": "london",
                "suggested": true
            }
        ]
    }
}
File path >>> 

```

[1]: https://github.com/tgallice/wit-php
[2]: https://wit.ai/
[3]: http://symfony.com/doc/current/components/console/introduction.html
[4]: https://wit.ai/docs/quickstart
