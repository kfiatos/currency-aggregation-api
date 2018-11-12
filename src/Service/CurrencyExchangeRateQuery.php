<?php

namespace App\Service;

use App\Entity\CurrencyExchangeRate;
use App\Entity\Enum\CacheKeys;
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
     * @var Cache
     */
    protected $cache;

    /**
     * CurrencyExchangeRateQuery constructor.
     * @param CurrencyExchangeRateRepository $currencyExchangeRateRepository
     * @param Cache $cache
     */
    public function __construct(CurrencyExchangeRateRepository $currencyExchangeRateRepository, Cache $cache)
    {
        $this->currencyExchangeRateRepository = $currencyExchangeRateRepository;
        $this->cache = $cache->getCacheService();
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
     * @return CurrencyExchangeRate|mixed|null
     */
    public function findOneByCurrencyCode(string $currencyCode)
    {
        $cacheKey = md5(CacheKeys::CURRENT_CURRENCY_RATE_KEY . $currencyCode);
        $cachedItem = $this->cache->getItem($cacheKey);

        if (false === $cachedItem->isHit()) {
            $currencyExchangeRate = $this->currencyExchangeRateRepository->findOneByCurrencyCode($currencyCode);
            $cachedItem->set(serialize($currencyExchangeRate));
            $this->cache->save($cachedItem);
        } else  {
            $currencyExchangeRate = unserialize($cachedItem->get());
        }
        return $currencyExchangeRate;
    }

    /**
     * @return array
     */
    public function findAllCurrencyCodes()
    {
        $cacheKey = md5(CacheKeys::GET_CURRENCY_CODES_KEY);
        $cachedItem = $this->cache->getItem($cacheKey);

        if (false === $cachedItem->isHit()) {
            $currencyCodes = $this->currencyExchangeRateRepository->findAllCurrencyCodes();
            $cachedItem->set(serialize($currencyCodes));
            $this->cache->save($cachedItem);
        } else  {
            $currencyCodes = unserialize($cachedItem->get());
        }

        return $currencyCodes;
    }

}