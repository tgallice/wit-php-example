<?php

require_once '../vendor/autoload.php';

$application = new \Symfony\Component\Console\Application();
$application->add(new \Tgallice\WitDemo\Command\QuickstartCommand());
$application->add(new \Tgallice\WitDemo\Command\IntentTextCommand());
$application->add(new \Tgallice\WitDemo\Command\IntentSpeechCommand());
$application->run();
