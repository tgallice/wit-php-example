<?php

namespace Tgallice\WitDemo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Tgallice\Wit\Client;
use Tgallice\Wit\MessageApi;

class MessageCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('wit:message')
            ->setDescription('Extract meaning of a text message')
            ->addArgument(
                'token',
                InputArgument::REQUIRED,
                'Access token ID'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $token = $input->getArgument('token');
        $client = new Client($token);
        $api =  new MessageApi($client);

        ask:

        $helper = $this->getHelper('question');
        $messagePrompt = new Question('>>> ');
        $message = $helper->ask($input, $output, $messagePrompt);
        $intent = $api->extractMeaning($message);

        $output->writeln('<info>+ Response body :</info>');
        $output->writeln('<comment>'.json_encode($intent, JSON_PRETTY_PRINT).'</comment>');

        goto ask;
    }
}
