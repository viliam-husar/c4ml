<?php

namespace ViliamHusar\C4ml\Console;

use ViliamHusar\C4ml\Console\Command\C4mlCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;


class C4mlApplication extends Application
{
    protected function getCommandName(InputInterface $input)
    {
        return 'c4ml';
    }

    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = new C4mlCommand();

        return $defaultCommands;
    }

    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}