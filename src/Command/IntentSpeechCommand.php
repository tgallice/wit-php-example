<?php

namespace Tgallice\WitDemo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Tgallice\Wit\Api;
use Tgallice\Wit\Client;


class IntentSpeechCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('wit:intent:speech')
            ->setDescription('Interactive converse with the Wit.ai api')
            ->addArgument(
                'token',
                InputArgument::REQUIRED,
                'App token ID'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $token = $input->getArgument('token');
        $client = new Client($token);
        $api =  new Api($client);

        ask:

        $helper = $this->getHelper('question');
        $messagePrompt = new Question('File path >>> ');
        $file = $helper->ask($input, $output, $messagePrompt);

        if (!file_exists($file)) {
            $output->writeln('<error>Invalid File</error>');
            goto ask;
        }

        if (0 !== strpos($file, '/')) {
            $file = realpath(__DIR__).'/../'.$file;
        }

        $output->writeln('<info>+ Please wait...</info>');

        $intent = $api->getIntentBySpeech($file);

        $output->writeln('<info>+ Response body :</info>');
        $output->writeln('<comment>'.json_encode($intent, JSON_PRETTY_PRINT).'</comment>');

        goto ask;
    }
}
