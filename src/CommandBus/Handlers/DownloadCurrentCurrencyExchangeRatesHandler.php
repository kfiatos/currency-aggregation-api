<?php

namespace App\CommandBus\Handlers;

use App\CommandBus\Commands\DownloadCurrentCurrencyExchangeRatesCommand;
use App\Service\Interfaces\CurrencyApiInterface;

/**
 * Class DownloadCurrentCurrencyExchangeRatesHandler
 * @package App\CommandBus\Handlers
 */
class DownloadCurrentCurrencyExchangeRatesHandler
{
    /**
     * @var CurrencyApiInterface
     */
    protected $currencyApiClient;

    public function __construct(CurrencyApiInterface $currencyApiClient)
    {
        $this->currencyApiClient = $currencyApiClient;
    }

    /**
     * @param DownloadCurrentCurrencyExchangeRatesCommand $command
     */
    public function handle(DownloadCurrentCurrencyExchangeRatesCommand $command): void
    {
        $this->currencyApiClient->getCurrentExchangeRateForAllCurrencies();
    }
}