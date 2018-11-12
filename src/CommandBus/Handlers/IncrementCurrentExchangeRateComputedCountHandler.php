<?php


namespace App\CommandBus\Handlers;


use App\CommandBus\Commands\IncrementCurrentExchangeRateComputedCountCommand;
use App\Service\CurrencyExchangeRate;

class IncrementCurrentExchangeRateComputedCountHandler
{
    /**
     * @var CurrencyExchangeRate
     */
    protected $currencyExchangeRateService;

    /**
     * IncrementCurrentExchangeRateComputedCounterHandler constructor.
     * @param CurrencyExchangeRate $currencyExchangeRateService
     */
    public function __construct(CurrencyExchangeRate $currencyExchangeRateService)
    {
        $this->currencyExchangeRateService = $currencyExchangeRateService;
    }

    /**
     * @param IncrementCurrentExchangeRateComputedCountCommand $command
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(IncrementCurrentExchangeRateComputedCountCommand $command)
    {
        $entity = $this->currencyExchangeRateService->findOneByCurrencyCode($command->getCurrencyCode());
        $entity->incrementComputedCount();
        $this->currencyExchangeRateService->store($entity);
    }

}