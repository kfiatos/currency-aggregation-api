<?php

namespace App\CommandBus\Handlers;


use App\CommandBus\Commands\IncrementCurrentExchangeRateComputedCountCommand;
use App\Service\CurrencyExchangeRate;
use App\Service\CurrencyExchangeRateQuery;

class IncrementCurrentExchangeRateComputedCountHandler
{
    /**
     * @var CurrencyExchangeRate
     */
    protected $currencyExchangeRateService;

    /**
     * @var CurrencyExchangeRateQuery
     */
    protected $currencyExchangeRateQueryService;

    /**
     * IncrementCurrentExchangeRateComputedCountHandler constructor.
     * @param CurrencyExchangeRate $currencyExchangeRateService
     * @param CurrencyExchangeRateQuery $currencyExchangeRateQueryService
     */
    public function __construct(
        CurrencyExchangeRate $currencyExchangeRateService,
        CurrencyExchangeRateQuery $currencyExchangeRateQueryService
    ) {
        $this->currencyExchangeRateService = $currencyExchangeRateService;
        $this->currencyExchangeRateQueryService = $currencyExchangeRateQueryService;
    }

    /**
     * @param IncrementCurrentExchangeRateComputedCountCommand $command
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(IncrementCurrentExchangeRateComputedCountCommand $command)
    {
        $entity = $this->currencyExchangeRateQueryService->findOneByCurrencyCode($command->getCurrencyCode());
        $entity->incrementComputedCount();
        $this->currencyExchangeRateService->store($entity);
    }

}