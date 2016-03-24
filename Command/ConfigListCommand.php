<?php

namespace ItBlaster\SingleConfigBundle\Command;

use ItBlaster\SingleConfigBundle\Model\Config;
use ItBlaster\SingleConfigBundle\Model\ConfigQuery;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ConfigListCommand extends ContainerAwareCommand
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
            ->setName('config:list')
            ->setDescription('return config value')
            ->addArgument('config_name', InputArgument::OPTIONAL, "Config name")
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ConsoleOutput $output */
        $this->output = $output;

        $service = $this->getContainer()->get('it_blaster_single_config.service');

        foreach ($service->get() as $name => $value) {
            $this->log('<info>'.$name.'</info><comment>: '.$value.'</comment>');
        }
    }

}