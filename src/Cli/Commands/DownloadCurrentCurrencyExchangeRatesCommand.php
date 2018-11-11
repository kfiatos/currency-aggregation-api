<?php

namespace App\Cli\Commands;


use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DownloadCurrentCurrencyExchangeRatesCommand
 * @package App\Cli\Commands
 */
class DownloadCurrentCurrencyExchangeRatesCommand extends Command
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * DownloadCurrentCurrencyExchangeRatesCommand constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:download-current-currency-exchange-rates')

            ->setDescription('Downloads current currency exchange rates')

            ->setHelp
            ('This command allows you to download current currency rates and store them in database for later usage');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}