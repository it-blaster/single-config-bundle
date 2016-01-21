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
     * @var array Вся база конфигов
     */
    public static $data;

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
            ->setDescription('command for testing')
            ->addArgument('config_name', InputArgument::OPTIONAL, "Companies for checking")
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ConsoleOutput $output */
        $this->output = $output;

        $config_name = $input->getArgument('config_name');
        if (!$config_name) {
            $this->log('Укажите имя конфига');
            die();
        }

        $config = Config::get($config_name);
        if (!$config) {
            $this->log('Конфиг по указанному имени не найден');
            die();
        }

        $this->log($config);
    }

}