<?php

namespace App\Service;

use App\CommandBus\Commands\CalculateAverageExchangeRatesCommand;
use App\Dto\PreparedCurrencyTableDto;
use App\Repository\CurrencyExchangeRateRepository;
use App\Entity\CurrencyExchangeRate as CurrencyExchangeRateEntity;
use League\Tactician\CommandBus;

/**
 * Class CurrencyExchangeRate
 * @package App\Service
 */
class CurrencyExchangeRate
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * @var CurrencyExchangeRateRepository
     */
    protected $currencyExchangeRateRepository;

    /**
     * CurrencyExchangeRate constructor.
     * @param CommandBus $commandBus
     * @param CurrencyExchangeRateRepository $currencyExchangeRateRepository
     */
    public function __construct(CommandBus $commandBus, CurrencyExchangeRateRepository $currencyExchangeRateRepository)
    {
        $this->commandBus = $commandBus;
        $this->currencyExchangeRateRepository = $currencyExchangeRateRepository;
    }

    /**
     * @param array $apiData
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function storeApiData(array $apiData): void
    {
        /** @var PreparedCurrencyTableDto $preparedDto */
        foreach ($apiData as $preparedDto) {
            $this->currencyExchangeRateRepository->storeByDto($preparedDto);
        }
        //Recalculate average exchange rates
        $command = new CalculateAverageExchangeRatesCommand();
        $this->commandBus->handle($command);
    }

    /**
     * @param CurrencyExchangeRateEntity $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function store(CurrencyExchangeRateEntity $entity)
    {
        $this->currencyExchangeRateRepository->store($entity);
    }
}