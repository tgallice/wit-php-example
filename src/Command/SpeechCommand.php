<?php

namespace Tgallice\WitDemo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Tgallice\Wit\Client;
use Tgallice\Wit\SpeechApi;

class SpeechCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('wit:speech')
            ->setDescription('Extract meaning of a speech file')
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
        $api =  new SpeechApi($client);

        ask:

        $helper = $this->getHelper('question');
        $messagePrompt = new Question('File path >>> ');
        $file = $helper->ask($input, $output, $messagePrompt);

        if (!file_exists($file)) {
            $output->writeln('<error>Invalid File</error>');
            goto ask;
        }

        if (0 !== strpos($file, '/')) {
            $file = __DIR__.'/../../'.$file;
        }

        $output->writeln('<info>+ Please wait...</info>');

        $intent = $api->extractMeaning($file);

        $output->writeln('<info>+ Response body :</info>');
        $output->writeln('<comment>'.json_encode($intent, JSON_PRETTY_PRINT).'</comment>');

        goto ask;
    }
}
