<?php

namespace App\Dto\Api;

use App\Entity\CurrencyExchangeRate;

/**
 * Class CurrentCurrencyExchangeRateDto
 * @package App\Dto\Api
 */
class CurrentCurrencyExchangeRateDto
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
     * @var float
     */
    protected $exchangeRate;

    /**
     * CurrentCurrencyExchangeRateDto constructor.
     * @param CurrencyExchangeRate $currencyExchangeRate
     */
    public function __construct(CurrencyExchangeRate $currencyExchangeRate)
    {
        $this->currencyCode = $currencyExchangeRate->getCurrencyCode();
        $this->updatedDate = $currencyExchangeRate->getEffectiveDate();
        $this->exchangeRate = $currencyExchangeRate->getRate();
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