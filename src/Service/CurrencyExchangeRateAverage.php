<?php

namespace App\Service;

use App\CommandBus\Commands\IncrementCurrentExchangeRateComputedCountCommand;
use App\Entity\CurrencyExchangeRateAverage as CurrencyExchangeRateAverageEntity;
use App\Repository\CurrencyExchangeRateAverageRepository;
use League\Tactician\CommandBus;

/**
 * Class CurrencyExchangeRateAverage
 * @package App\Service
 */
class CurrencyExchangeRateAverage
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * @var CurrencyExchangeRateAverageRepository
     */
    protected $currencyExchangeRateAverageRepository;

    /**
     * CurrencyExchangeRate constructor.
     * @param CommandBus $commandBus
     * @param CurrencyExchangeRateAverageRepository $currencyExchangeRateAverageRepository
     */
    public function __construct(
        CommandBus $commandBus,
        CurrencyExchangeRateAverageRepository $currencyExchangeRateAverageRepository
    ) {
        $this->commandBus = $commandBus;
        $this->currencyExchangeRateAverageRepository = $currencyExchangeRateAverageRepository;
    }

    /**
     * @param CurrencyExchangeRateAverageEntity $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function store(CurrencyExchangeRateAverageEntity $entity): void
    {
        if ($this->currencyExchangeRateAverageRepository->store($entity)) {
            $command = new IncrementCurrentExchangeRateComputedCountCommand($entity->getCurrencyCode());
            $this->commandBus->handle($command);
        }
    }
}