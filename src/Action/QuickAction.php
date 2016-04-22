<?php

namespace Tgallice\WitDemo\Action;

use Symfony\Component\Console\Output\OutputInterface;
use Tgallice\Wit\ActionMapping;
use Tgallice\Wit\Helper;
use Tgallice\Wit\Model\Context;
use Tgallice\Wit\Model\Step;

class QuickAction extends ActionMapping
{
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function action($sessionId, $actionName, Context $context)
    {
        $this->output->writeln(sprintf('<info>+ Action : %s</info>', $actionName));

        if ($actionName === 'fetch-weather') {
            $context = $this->fetchWeather($sessionId, $context);
        }

        return $context;
    }

    public function say($sessionId, $message, Context $context)
    {
        $this->output->writeln('<info>+ Say : '.$message.'</info>');
        $this->output->writeln('+++ '.$message);
    }

    /**
     * @inheritdoc
     */
    public function error($sessionId, Context $context, $error = '', array $step = null)
    {
        $this->output->writeln('<error>'.$error.'</error>');
    }

    public function merge($sessionId, Context $context, array $entities)
    {
        $this->output->writeln('<info>+ Merge context with :</info>');
        $this->output->writeln('<comment>'.json_encode($entities, JSON_PRETTY_PRINT).'</comment>');
        $loc = Helper::getFirstEntityValue('location', $entities);
        $context->add('loc', $loc);

        return $context;
    }

    public function stop($sessionId, Context $context)
    {
        $this->output->writeln('<info>+ Stop</info>');
    }

    private function fetchWeather($sessionId, Context $context)
    {
        $context->add('forecast', 'sunny');

        return $context;
    }
}
