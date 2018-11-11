<?php

namespace App\Service;

use App\Service\Interfaces\CurrencyApiInterface;

/**
 * Class NbpApiClient
 * @package App\Service
 */
class NbpApiClient implements CurrencyApiInterface
{
    /**
     * @param string $currency
     * @return string|null
     */
    public function getCurrentExchangeRateForCurrency(string $currency): ?string
    {
        // TODO: Implement getCurrentExchangeRateForCurrency() method.
    }

    /**
     * @return string|null
     */
    public function getCurrentExchangeRateForAllCurrencies(): ?string
    {
        // TODO: Implement getCurrentExchangeRateForAllCurrencies() method.
    }

}