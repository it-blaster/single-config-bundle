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
            ->setName('config:get')
            ->setDescription('return config value')
            ->addArgument('config_name', InputArgument::OPTIONAL, "Config name")
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ConsoleOutput $output */
        $this->output = $output;

        $config_name = $input->getArgument('config_name');
        if (!$config_name) {
            $this->log('Укажите имя конфига');
            return;
        }

        $config = $this->getContainer()->get('it_blaster_single_config.service')->get($config_name);
        if ($config === null) {
            $this->log('Конфиг по указанному имени не найден');
            return;
        }

        $this->log($config);
    }

}