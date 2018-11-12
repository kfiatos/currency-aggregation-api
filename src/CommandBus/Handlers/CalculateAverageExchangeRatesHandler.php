<?php

namespace App\CommandBus\Handlers;


use App\CommandBus\Commands\CalculateAverageExchangeRatesCommand;
use App\Service\AverageExchangeRatesCalculator;
use App\Service\CurrencyExchangeRateQuery;

class CalculateAverageExchangeRatesHandler
{
    /**
     * @var AverageExchangeRatesCalculator
     */
    protected $exchangeRateCalculatorService;

    /**
     * @var CurrencyExchangeRateQuery
     */
    protected $currencyExchangeRateQueryService;

    /**
     * CalculateAverageExchangeRatesHandler constructor.
     * @param AverageExchangeRatesCalculator $exchangeRateCalculatorService
     * @param CurrencyExchangeRateQuery $currencyExchangeRateQueryService
     */
    public function __construct(
        AverageExchangeRatesCalculator $exchangeRateCalculatorService,
        CurrencyExchangeRateQuery $currencyExchangeRateQueryService
    ) {
        $this->exchangeRateCalculatorService = $exchangeRateCalculatorService;
        $this->currencyExchangeRateQueryService = $currencyExchangeRateQueryService;
    }

    /**
     * @param CalculateAverageExchangeRatesCommand $command
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(CalculateAverageExchangeRatesCommand $command) {
        $currencyExchangeRates = $this->currencyExchangeRateQueryService->findAll();
        $this->exchangeRateCalculatorService
            ->updateComputedAverageExchangeRates($currencyExchangeRates);
    }
}