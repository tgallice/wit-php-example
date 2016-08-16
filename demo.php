<?php

require_once 'vendor/autoload.php';

$application = new \Symfony\Component\Console\Application();
$application->add(new \Tgallice\WitDemo\Command\QuickstartCommand());
$application->add(new \Tgallice\WitDemo\Command\MessageCommand());
$application->add(new \Tgallice\WitDemo\Command\SpeechCommand());
$application->run();
