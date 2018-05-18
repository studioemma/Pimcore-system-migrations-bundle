<?php

namespace StudioEmma\SystemMigrationsBundle\Command;

use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use StudioEmma\SystemMigrationsBundle\Service\Updater;

class UpdateCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('studioemma:systemmigrations:update');
        $this->setDescription('run system db migration updates');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @throws InvalidConfigException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('update');
        $updater = new Updater();
        $updater->run();
    }
}
