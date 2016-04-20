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
php demo.php wit:quickstart <app_token>
```

Intent by text
--------------

This command provides an easy way to get Intent based on text input.

```bash
php demo.php wit:intent:text <app_token>
```

Intent by speech
----------------

You can test to get Intent by speech. A sample is provided, but you can use your own.

```bash
php demo.php wit:intent:speech <app_token>
```

[1]: https://github.com/tgallice/wit-php
[2]: https://wit.ai/
[3]: http://symfony.com/doc/current/components/console/introduction.html
[4]: https://wit.ai/docs/quickstart
