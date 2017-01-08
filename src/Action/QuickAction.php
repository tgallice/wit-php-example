<?php

namespace Tgallice\WitDemo\Action;

use Symfony\Component\Console\Output\OutputInterface;
use Tgallice\Wit\ActionMapping;
use Tgallice\Wit\Helper;
use Tgallice\Wit\Model\Context;
use Tgallice\Wit\Model\Step\Action;
use Tgallice\Wit\Model\Step\Message;
use Tgallice\Wit\Model\Step\Merge;
use Tgallice\Wit\Model\Step\Stop;

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
    public function action($sessionId, Context $context, Action $step)
    {
        $this->output->writeln(sprintf('<info>+ (%f) Action : %s</info>', $step->getConfidence(), $step->getAction()));

        if (!empty($step->getEntities())) {
            $this->output->writeln('<info>+ Entities provided:</info>');
            $this->output->writeln('<comment>'.json_encode($step->getEntities(), JSON_PRETTY_PRINT).'</comment>');
        }

        if ($step->getAction() === 'getForecast') {
            $context = $this->getForecast($context, $step->getEntities());
        }

        return $context;
    }

    /**
     * @inheritdoc
     */
    public function say($sessionId, Context $context, Message $step)
    {
        $this->output->writeln(sprintf('<info>+ (%f) Say : %s</info>', $step->getConfidence(), $step->getMessage()));
        $this->output->writeln('+++ '.$step->getMessage());
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
    public function merge($sessionId, Context $context, Merge $step)
    {
        $this->output->writeln(sprintf('<info>+ (%f) Merge context with :</info>', $step->getConfidence()));
        $this->output->writeln('<comment>'.json_encode($step->getEntities(), JSON_PRETTY_PRINT).'</comment>');

        return $context;
    }

    /**
     * @inheritdoc
     */
    public function stop($sessionId, Context $context, Stop $step)
    {
        $this->output->writeln(sprintf('<info>+ (%f) Stop</info>', $step->getConfidence()));
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
