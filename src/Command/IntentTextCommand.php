<?php

namespace Tgallice\WitDemo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Tgallice\Wit\Api;
use Tgallice\Wit\Client;

class IntentTextCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('wit:intent:text')
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
        $messagePrompt = new Question('>>> ');
        $message = $helper->ask($input, $output, $messagePrompt);
        $intent = $api->getIntentByText($message);

        $output->writeln('<info>+ Response body :</info>');
        $output->writeln('<comment>'.json_encode($intent, JSON_PRETTY_PRINT).'</comment>');

        goto ask;
    }
}
