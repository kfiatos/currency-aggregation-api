<?php

namespace App\Service;

use App\Entity\CurrencyExchangeRateAverage as CurrencyExchangeRateAverageEntity;
use App\Repository\CurrencyExchangeRateAverageRepository;

/**
 * Class CurrencyExchangeRateAverageQuery
 * @package App\Service
 */
class CurrencyExchangeRateAverageQuery
{
    /**
     * @var CurrencyExchangeRateAverageRepository
     */
    protected $currencyExchangeRateAverageRepository;

    /**
     * CurrencyExchangeRate constructor.
     * @param CurrencyExchangeRateAverageRepository $currencyExchangeRateAverageRepository
     */
    public function __construct(
        CurrencyExchangeRateAverageRepository $currencyExchangeRateAverageRepository
    ) {
        $this->currencyExchangeRateAverageRepository = $currencyExchangeRateAverageRepository;
    }

    /**
     * @return CurrencyExchangeRateAverageEntity[]
     */
    public function findAll()
    {
        return $this->currencyExchangeRateAverageRepository->findAll();
    }

    /**
     * @param string $currencyCode
     * @return CurrencyExchangeRateAverageEntity|null
     */
    public function findOneByCurrencyCode(string $currencyCode): ?CurrencyExchangeRateAverageEntity
    {
        return $this->currencyExchangeRateAverageRepository->findOneByCurrencyCode($currencyCode);
    }
}