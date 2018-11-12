<?php

namespace App\CommandBus\Handlers;

use App\CommandBus\Commands\DownloadCurrentCurrencyExchangeRatesCommand;
use App\Service\CurrencyExchangeRate;
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

    /**
     * @var CurrencyExchangeRate
     */
    protected $exchangeRatesService;

    /**
     * DownloadCurrentCurrencyExchangeRatesHandler constructor.
     * @param CurrencyApiInterface $currencyApiClient
     * @param CurrencyExchangeRate $exchangeRatesService
     */
    public function __construct(CurrencyApiInterface $currencyApiClient, CurrencyExchangeRate $exchangeRatesService)
    {
        $this->currencyApiClient = $currencyApiClient;
        $this->exchangeRatesService = $exchangeRatesService;
    }

    /**
     * @param DownloadCurrentCurrencyExchangeRatesCommand $command
     */
    public function handle(DownloadCurrentCurrencyExchangeRatesCommand $command): void
    {
        $apiData = $this->currencyApiClient->getCurrentExchangeRateForAllCurrencies();
        $this->exchangeRatesService->storeApiData($apiData);
    }
}