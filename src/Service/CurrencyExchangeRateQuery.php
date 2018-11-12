<?php

namespace App\Service;

use App\Entity\CurrencyExchangeRate;
use App\Repository\CurrencyExchangeRateRepository;

/**
 * Class CurrencyExchangeRateQueryService
 * @package App\Service
 */
class CurrencyExchangeRateQuery
{
    /**
     * @var CurrencyExchangeRateRepository
     */
    protected $currencyExchangeRateRepository;

    /**
     * CurrencyExchangeRate constructor.
     * @param CurrencyExchangeRateRepository $currencyExchangeRateRepository
     */
    public function __construct(CurrencyExchangeRateRepository $currencyExchangeRateRepository)
    {
        $this->currencyExchangeRateRepository = $currencyExchangeRateRepository;
    }

    /**
     * @return CurrencyExchangeRate[]
     */
    public function findAll()
    {
        return $this->currencyExchangeRateRepository->findAll();
    }

    /**
     * @param int $id
     * @return CurrencyExchangeRate|null
     */
    public function findOneById(int $id): ?CurrencyExchangeRate
    {
        return $this->currencyExchangeRateRepository->findOneById($id);
    }

    /**
     * @param string $currencyCode
     * @return CurrencyExchangeRate|null
     */
    public function findOneByCurrencyCode(string $currencyCode)
    {
        return $this->currencyExchangeRateRepository->findOneByCurrencyCode($currencyCode);
    }

}