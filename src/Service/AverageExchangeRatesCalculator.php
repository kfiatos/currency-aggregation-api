<?php

namespace App\Service;

use App\Entity\CurrencyExchangeRate;
use App\Entity\CurrencyExchangeRateAverage;
use App\Service\CurrencyExchangeRate as CurrencyExchangeRateService;
use App\Service\CurrencyExchangeRateAverage as CurrencyExchangeRateAverageService;

/**
 * Class AverageExchangeRatesCalculator
 * @package App\Service
 */
class AverageExchangeRatesCalculator
{
    /**
     * @var CurrencyExchangeRate
     */
    protected $currencyExchangeRateService;

    /**
     * @var CurrencyExchangeRateAverageService
     */
    protected $currencyExchangeRateAverageService;

    /**
     * @var CurrencyExchangeRateAverageQuery
     */
    protected $currencyExchangeRateAverageQueryService;

    /**
     * AverageExchangeRatesCalculator constructor.
     * @param \App\Service\CurrencyExchangeRate $currencyExchangeRateService
     * @param \App\Service\CurrencyExchangeRateAverage $currencyExchangeRateAverageService
     * @param CurrencyExchangeRateAverageQuery $currencyExchangeRateAverageQueryService
     */
    public function __construct(
        CurrencyExchangeRateService $currencyExchangeRateService,
        CurrencyExchangeRateAverageService $currencyExchangeRateAverageService,
        CurrencyExchangeRateAverageQuery $currencyExchangeRateAverageQueryService
    ) {
        $this->currencyExchangeRateService = $currencyExchangeRateService;
        $this->currencyExchangeRateAverageService =$currencyExchangeRateAverageService;
        $this->currencyExchangeRateAverageQueryService = $currencyExchangeRateAverageQueryService;
    }

    /**
     * @param array $currencyExchangeRates
     */
    public function updateComputedAverageExchangeRates(array $currencyExchangeRates)
    {
        /** @var \App\Entity\CurrencyExchangeRate $currencyExchangeRate */
        foreach ($currencyExchangeRates as $currencyExchangeRate) {
                $averageExchangeRate =
                    $this->currencyExchangeRateAverageQueryService
                        ->findOneByCurrencyCode($currencyExchangeRate->getCurrencyCode());

            if (empty($averageExchangeRate)) {
                $averageExchangeRate = new CurrencyExchangeRateAverage();
            } else {
                if ($averageExchangeRate->getEffectiveDate()->getTimestamp() >=
                    $currencyExchangeRate->getEffectiveDate()->getTimestamp()) {
                    continue;
                }
            }

            $currentAverageRate = $this->computeAverageExchangeRate(
                $currencyExchangeRate,
                $averageExchangeRate
            );
            $averageExchangeRate
                ->setCurrencyCode($currencyExchangeRate->getCurrencyCode())
                ->setAverageRate($currentAverageRate)
                ->setCurrencyCode($currencyExchangeRate->getCurrencyCode())
                ->setEffectiveDate($currencyExchangeRate->getEffectiveDate())
                ->setUpdatedDate(new \DateTime());

            $this->currencyExchangeRateAverageService->store($averageExchangeRate);
        }
    }

    /**
     * @param CurrencyExchangeRate $currency
     * @param CurrencyExchangeRateAverage $rateAverage
     * @return float|int
     */
    public function computeAverageExchangeRate(
        CurrencyExchangeRate $currency,
        CurrencyExchangeRateAverage $rateAverage
    ) {
        $nextAverageRate =
            (($rateAverage->getAverageRate() * $currency->getComputedCount()) + $currency->getRate()) / ($currency->getComputedCount() + 1);
        return $nextAverageRate;
    }
}