<?php

namespace App\Service\Interfaces;


interface CurrencyApiInterface
{
    /**
     * @param string $currency
     * @return string|null
     */
    public function getCurrentExchangeRateForCurrency(string $currency): ?string;

    /**
     * @return string|null
     */
    public function getCurrentExchangeRateForAllCurrencies(): ?string;
}