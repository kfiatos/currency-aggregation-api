<?php

namespace App\CommandBus\Handlers;


use App\CommandBus\Commands\CalculateAverageExchangeRatesCommand;
use App\Service\AverageExchangeRatesCalculator;
use App\Service\CurrencyExchangeRate;
use App\Service\CurrencyExchangeRateAverage;

class CalculateAverageExchangeRatesHandler
{
    /**
     * @var AverageExchangeRatesCalculator
     */
    protected $exchangeRateCalculatorService;

    /**
     * @var CurrencyExchangeRate
     */
    protected $currencyExchangeRateService;

    /**
     * CalculateAverageExchangeRatesHandler constructor.
     * @param AverageExchangeRatesCalculator $exchangeRateCalculatorService
     * @param CurrencyExchangeRate $currencyExchangeRateService
     */
    public function __construct(
        AverageExchangeRatesCalculator $exchangeRateCalculatorService,
        CurrencyExchangeRate $currencyExchangeRateService
    ) {
        $this->exchangeRateCalculatorService = $exchangeRateCalculatorService;
        $this->currencyExchangeRateService = $currencyExchangeRateService;
    }


    /**
     * @param CalculateAverageExchangeRatesCommand $command
     */

    public function handle(CalculateAverageExchangeRatesCommand $command) {
        $currencyExchangeRates = $this->currencyExchangeRateService->findAll();
        $this->exchangeRateCalculatorService
            ->updateComputedAverageExchangeRates($currencyExchangeRates);
    }
}