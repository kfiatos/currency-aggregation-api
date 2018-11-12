<?php

namespace App\Service;

use App\Entity\CurrencyExchangeRateAverage as CurrencyExchangeRateAverageEntity;
use App\Entity\Enum\CacheKeys;
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
     * @var Cache
     */
    protected $cache;

    /**
     * CurrencyExchangeRateAverageQuery constructor.
     * @param CurrencyExchangeRateAverageRepository $currencyExchangeRateAverageRepository
     * @param Cache $cache
     */
    public function __construct(
        CurrencyExchangeRateAverageRepository $currencyExchangeRateAverageRepository,
        Cache $cache
    ) {
        $this->currencyExchangeRateAverageRepository = $currencyExchangeRateAverageRepository;
        $this->cache = $cache->getCacheService();
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
        $cacheKey = md5(CacheKeys::AVERAGE_CURRENCY_RATE_KEY . $currencyCode);
        $cachedItem = $this->cache->getItem($cacheKey);

        if (false === $cachedItem->isHit()) {
            $currencyExchangeRateAverage = $this->currencyExchangeRateAverageRepository->findOneByCurrencyCode($currencyCode);
            $cachedItem->set(serialize($currencyExchangeRateAverage));
            $this->cache->save($cachedItem);
        } else  {
            $currencyExchangeRateAverage = unserialize($cachedItem->get());
        }
        return $currencyExchangeRateAverage;
    }
}