<?php

namespace ItBlaster\SingleConfigBundle\Command;

use ItBlaster\SingleConfigBundle\Model\Config;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ConfigGetCommand extends ContainerAwareCommand
{
    protected $output;

    /**
     * Вывод ссобщения в консоль
     *
     * @param $message
     */
    protected function log($message)
    {
        //$output->writeln('<info>green color</info>');
        //$output->writeln('<comment>yellow text</comment>');
        //$output->writeln('<error>red</error>');
        $this->output->writeln($message);
    }

    protected function configure()
    {
        $this
            ->setName('config:set')
            ->setDescription('set config')
            ->addArgument('config_name', InputArgument::OPTIONAL, "Config name")
            ->addArgument('config_value', InputArgument::OPTIONAL, "Config value")
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ConsoleOutput $output */
        $this->output = $output;

        $config_name = $input->getArgument('config_name');
        $config_value = $input->getArgument('config_value');

        if (!$config_name) {
            $this->log('Укажите имя конфига');
            die();
        }

        if (!$config_value) {
            $this->log('Укажите значение конфига');
            die();
        }


    }

}