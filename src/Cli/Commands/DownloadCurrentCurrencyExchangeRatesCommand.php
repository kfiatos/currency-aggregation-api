<?php

namespace App\Cli\Commands;


use App\CommandBus\Commands\DownloadCurrentCurrencyExchangeRatesCommand as DownloadCommand;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DownloadCurrentCurrencyExchangeRatesCommand
 * @package App\Cli\Commands
 */
class DownloadCurrentCurrencyExchangeRatesCommand extends BaseCommand
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

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Currency rates synchronization with NBP WEB Api started');
        $command = new DownloadCommand();
        $this->commandBus->handle($command);
        $output->writeln('Currency rates synchronization with NBP WEB Api ended');
    }
}