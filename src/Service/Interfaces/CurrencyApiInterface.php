<?php

namespace App\Service\Interfaces;


use App\Dto\RawCurrencyTableDto;

interface CurrencyApiInterface
{
    /**
     * @param string $currency
     * @return string|null
     */
    public function getCurrentExchangeRateForCurrency(string $currency): ?string;

    /**
     * @return RawCurrencyTableDto[]|null
     */
    public function getCurrentExchangeRateForAllCurrencies(): ?array ;
}