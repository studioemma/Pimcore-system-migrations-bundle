<?php

namespace StudioEmma\SystemMigrationsBundle\Command;

use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use StudioEmma\SystemMigrationsBundle\Service\Updater;

class InitCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('studioemma:systemmigrations:init');
        $this->setDescription('run system db migration updates');
        $this->addArgument(
            'buildnumber',
            InputArgument::REQUIRED,
            'The build you want to start from'
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @throws InvalidConfigException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $buildNr = (int) $input->getArgument('buildnumber');
        $output->writeln('init' . $buildNr);
        $updater = new Updater();
        $updater->init($buildNr);
    }
}
