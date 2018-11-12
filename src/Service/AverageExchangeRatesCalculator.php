<?php

namespace App\Service;


use App\Entity\CurrencyExchangeRateAverage;
use App\Entity\CurrencyExchangeRate;
use App\Service\CurrencyExchangeRate as CurrencyExchangeRateService;
use App\Service\CurrencyExchangeRateAverage as CurrencyExchangeRateAverageService;

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
     * AverageExchangeRatesCalculator constructor.
     * @param CurrencyExchangeRateService $currencyExchangeRateService
     * @param CurrencyExchangeRateAverageService $currencyExchangeRateAverageService
     */
    public function __construct(
        CurrencyExchangeRateService $currencyExchangeRateService,
        CurrencyExchangeRateAverageService $currencyExchangeRateAverageService
    ) {
        $this->currencyExchangeRateService = $currencyExchangeRateService;
        $this->currencyExchangeRateAverageService = $currencyExchangeRateAverageService;
    }

    /**
     * @param CurrencyExchangeRate[]
     * @param CurrencyExchangeRateAverage[]
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateComputedAverageExchangeRates(array $currencyExchangeRates)
    {
        /** @var \App\Entity\CurrencyExchangeRate $currencyExchangeRate */
        foreach ($currencyExchangeRates as $currencyExchangeRate) {
                $averageExchangeRate =
                    $this->currencyExchangeRateAverageService->findOneByCurrencyCode($currencyExchangeRate->getCurrencyCode());

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