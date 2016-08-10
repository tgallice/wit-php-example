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

    /**
     * @inheritdoc
     */
    public function action($sessionId, $actionName, Context $context, array $entities = [])
    {
        $this->output->writeln(sprintf('<info>+ Action : %s</info>', $actionName));

        if (!empty($entities)) {
            $this->output->writeln('<info>+ Entities provided:</info>');
            $this->output->writeln('<comment>'.json_encode($entities, JSON_PRETTY_PRINT).'</comment>');
        }

        if ($actionName === 'getForecast') {
            $context = $this->getForecast($context, $entities);
        }

        return $context;
    }

    /**
     * @inheritdoc
     */
    public function say($sessionId, $message, Context $context, array $entities = [])
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

    /**
     * @inheritdoc
     */
    public function merge($sessionId, Context $context, array $entities = [])
    {
        $this->output->writeln('<info>+ Merge context with :</info>');
        $this->output->writeln('<comment>'.json_encode($entities, JSON_PRETTY_PRINT).'</comment>');

        return $context;
    }

    /**
     * @inheritdoc
     */
    public function stop($sessionId, Context $context)
    {
        $this->output->writeln('<info>+ Stop</info>');
    }

    private function getForecast(Context $context, array $entities = [])
    {
        $loc = Helper::getFirstEntityValue('location', $entities);

        if (!$loc) {
            return new Context(['missingLocation' => true]);
        }

        return new Context(['forecast' => 'sunny in '.$loc]);
    }
}
