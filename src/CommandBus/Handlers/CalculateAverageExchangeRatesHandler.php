<?php

namespace App\CommandBus\Handlers;

use App\CommandBus\Commands\CalculateAverageExchangeRatesCommand;
use App\Service\AverageExchangeRatesCalculator;
use App\Service\Cache;
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
     * @var Cache
     */
    protected $cache;

    /**
     * CalculateAverageExchangeRatesHandler constructor.
     * @param AverageExchangeRatesCalculator $exchangeRateCalculatorService
     * @param CurrencyExchangeRateQuery $currencyExchangeRateQueryService
     * @param Cache $cache
     */
    public function __construct(
        AverageExchangeRatesCalculator $exchangeRateCalculatorService,
        CurrencyExchangeRateQuery $currencyExchangeRateQueryService,
        Cache $cache
    ) {
        $this->exchangeRateCalculatorService = $exchangeRateCalculatorService;
        $this->currencyExchangeRateQueryService = $currencyExchangeRateQueryService;
        $this->cache = $cache;
    }

    /**
     * @param CalculateAverageExchangeRatesCommand $command
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(CalculateAverageExchangeRatesCommand $command) {
        //should be moved elsewhere - for the sakes of simplicity stays here for now
        //Clear cache before update
        $this->cache->getCacheService()->clear();
        $currencyExchangeRates = $this->currencyExchangeRateQueryService->findAll();
        $this->exchangeRateCalculatorService
            ->updateComputedAverageExchangeRates($currencyExchangeRates);
    }
}