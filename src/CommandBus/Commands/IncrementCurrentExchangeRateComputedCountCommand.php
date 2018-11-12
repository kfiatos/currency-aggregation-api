<?php

namespace App\CommandBus\Commands;

/**
 * Class IncrementCurrentExchangeRateComputedCountCommand
 * @package App\CommandBus\Commands
 */
class IncrementCurrentExchangeRateComputedCountCommand
{
    /**
     * @var string
     */
    protected $currencyCode;

    /**
     * IncrementCurrentExchangeRateComputedCounter constructor.
     * @param string $currencyCode
     */
    public function __construct(string $currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /**
     * @param string $currencyCode
     * @return IncrementCurrentExchangeRateComputedCountCommand
     */
    public function setCurrencyCode(string $currencyCode): IncrementCurrentExchangeRateComputedCountCommand
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }
}