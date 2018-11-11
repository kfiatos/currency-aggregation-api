<?php

namespace App\CommandBus\Handlers;

use App\CommandBus\Commands\DownloadCurrentCurrencyExchangeRatesCommand;

/**
 * Class DownloadCurrentCurrencyExchangeRatesHandler
 * @package App\CommandBus\Handlers
 */
class DownloadCurrentCurrencyExchangeRatesHandler
{
    /**
     * @param DownloadCurrentCurrencyExchangeRatesCommand $command
     */
    public function handle(DownloadCurrentCurrencyExchangeRatesCommand $command): void
    {

    }
}