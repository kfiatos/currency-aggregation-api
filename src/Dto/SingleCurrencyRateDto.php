<?php


namespace App\Dto;


class SingleCurrencyRateDto
{
    /**
     * @var string
     */
    protected $currencyCode;

    /**
     * @var string
     */
    protected $currencyDescription;

    /**
     * @var float
     */
    protected $conversionRate;
    /**
     * SingleCurrencyRateDto constructor.
     * @param array $rate
     */
    public function __construct(array $rate)
    {
        $this->currencyCode = $rate['code'];
        $this->currencyDescription = $rate['currency'];
        $this->conversionRate = $rate['mid'];
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /**
     * @return string
     */
    public function getCurrencyDescription(): string
    {
        return $this->currencyDescription;
    }

    /**
     * @return float
     */
    public function getConversionRate(): float
    {
        return $this->conversionRate;
    }
}