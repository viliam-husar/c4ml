<?php

namespace ViliamHusar\C4ml\Console\Command;

use ViliamHusar\C4ml\C4ml;
use ViliamHusar\C4ml\GraphvizGenerator\GraphvizGenerator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

class C4mlCommand extends Command
{
    public function configure()
    {
        $this->setName('c4ml');
        $this->setDescription("Generates Graphviz diagram of C4 architecture model");
        $this->addArgument('source', InputArgument::REQUIRED);
        $this->addArgument('output', InputArgument::REQUIRED);
        $this->addOption('system', 's', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, "Specify internal systems with container view", []);
        $this->addOption('config', 'c', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, "Sets diagram options", []);
        $this->addOption('raw', 'r', InputOption::VALUE_NONE, "Returns raw DOT file");
        $this->addOption('format', 'f', InputOption::VALUE_OPTIONAL, "Output format of diagram (svg, png, jpeg)", 'svg');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $fileLocator = new FileLocator(array(getcwd()));
        $file = $fileLocator->locate($input->getArgument('source'));

        $model = C4ml::parse(file_get_contents($file));
        $graphvizGenerator = new GraphvizGenerator();

        // determine graph mode
        if (empty($input->getOption('system'))) {
            $mode = GraphvizGenerator::MODE_ALL;
        } else {
            $mode = GraphvizGenerator::MODE_SELECTIVE;
        }

        $graph = $graphvizGenerator->generate($model, $mode, $input->getOption('system'));

        $dotFile = tempnam(sys_get_temp_dir(), 'c4ml');
        file_put_contents($dotFile, (string)$graph);

        $arguments = [
            'dot',
            $dotFile,
            '-T' . $input->getOption('format'),
            '-o' . $input->getArgument('output'),
        ];

        $process = ProcessBuilder::create($arguments)->getProcess();

        $helper = $this->getHelper('process');

        $helper->run($output, $process);

        unlink($dotFile);
    }
}