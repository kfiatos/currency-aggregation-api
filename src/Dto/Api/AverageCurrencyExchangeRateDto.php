<?php

namespace App\Dto\Api;

use App\Entity\CurrencyExchangeRateAverage;

/**
 * Class AverageCurrencyExchangeRateDto
 * @package App\Dto\Api
 */
class AverageCurrencyExchangeRateDto
{
    /**
     * @var string
     */
    protected $currencyCode;

    /**
     * @var string
     */
    protected $updatedDate;

    /**
     * @var string
     */
    protected $currencyDescription;

    /**
     * @var float
     */
    protected $exchangeRate;

    /**
     * CurrentCurrencyExchangeRateDto constructor.
     * @param CurrencyExchangeRateAverage $currencyExchangeRateAverage
     */
    public function __construct(CurrencyExchangeRateAverage $currencyExchangeRateAverage)
    {
        $this->currencyCode = $currencyExchangeRateAverage->getCurrencyCode();
        $this->updatedDate = $currencyExchangeRateAverage->getEffectiveDate();
        $this->exchangeRate = $currencyExchangeRateAverage->getAverageRate();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'currency_code' => $this->currencyCode,
            'currency_rate' => $this->exchangeRate,
            'updated_date'  => $this->getUpdatedDate(),
        ];
    }

    protected function getUpdatedDate(): string
    {
        return $this->updatedDate->format('Y-m-d');
    }
}