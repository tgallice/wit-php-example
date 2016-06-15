Wit.ai php demo
===============

This is an interactive demo using the [tgallice/wit-php][1] sdk.

- You should create a [wit.ai][2] account before run the demo.
- Make sure to install dependencies with composer before 
running the demo.

All these demos are built with the [symfony/console][3] component and should be used with a CLI.

Quickstart demo
---------------

It's based on the quickstart tutorial of wit.ai which can be found [here][4]

```bash
$ php demo.php wit:quickstart <access_token>
>>> What is the weather ?           
+ Merge context with :
[]
+++ Where exactly?
>>> In London
+ Merge context with :
{
    "location": [
        {
            "confidence": 0.9979288322796,
            "type": "value",
            "value": "London",
            "suggested": true
        }
    ]
}
+ Action : fetch-weather
+++ I see it’s sunny today!
>>>
```

Intent by text
--------------

This command provides an easy way to get Intent based on text input.

```bash
$ php demo.php wit:intent:text <access_token>
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

You can test to get Intent by speech. A sample is provided, but you can use your own.

```bash
$ php demo.php wit:intent:speech <access_token>
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
