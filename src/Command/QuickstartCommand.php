<?php

namespace Tgallice\WitDemo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tgallice\Wit\Client;
use Tgallice\Wit\Conversation;
use Tgallice\Wit\ConverseApi;
use Tgallice\Wit\Model\Context;
use Tgallice\WitDemo\Action\QuickAction;

class QuickstartCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('wit:quickstart')
            ->setDescription('Interactive converse with the Wit.ai api')
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
        $api =  new ConverseApi($client);
        $actionMapping = new QuickAction($output);
        $conversation = new Conversation($api, $actionMapping);

        $sessionId = 'user-'.time();
        $context = new Context();

        ask:

        $helper = $this->getHelper('question');
        $messagePrompt = new Question('>>> ');
        $message = $helper->ask($input, $output, $messagePrompt);
        $context = $conversation->converse($sessionId, $message, $context);

        goto ask;
    }
}
