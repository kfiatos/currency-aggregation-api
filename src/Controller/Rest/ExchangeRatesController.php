<?php

namespace App\Controller\Rest;

use App\Dto\Api\AverageCurrencyExchangeRateDto;
use App\Dto\Api\CurrentCurrencyExchangeRateDto;
use App\Service\Cache;
use App\Service\CurrencyExchangeRateAverageQuery;
use App\Service\CurrencyExchangeRateQuery;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ExchangeRatesController
 * @package App\Controller\Rest
 */
class ExchangeRatesController extends AbstractController
{
    /**
     * @Annotations\Get("/exchange_rates/get_currency_codes")
     */
    public function getCurrencyCodes(CurrencyExchangeRateQuery $currencyExchangeRateQuery, Cache $cache)
    {
        $currencyExchangeRates = $currencyExchangeRateQuery->findAllCurrencyCodes();
        return View::create($currencyExchangeRates, 200);
    }

    /**
     * @Annotations\Get("/exchange_rates/get_current_rate/{code}")
     * @Annotations\QueryParam(name="code", requirements={"code : \d+"}, description="Get exchange rate for given currency code.")
     * @param string $code
     * @return View
     */
    public function getCurrentCurrencyRate(string $code, CurrencyExchangeRateQuery $currencyExchangeRateQuery, Cache $cache)
    {
        $currencyExchangeRate = $currencyExchangeRateQuery->findOneByCurrencyCode($code);
        if ($currencyExchangeRate) {
            $dto = new CurrentCurrencyExchangeRateDto($currencyExchangeRate);
            return View::create($dto->getData(), 200);
        }
        return View::create("Not found", 404);

    }
    /**
     * @Annotations\Get("/exchange_rates/get_average_rate/{code}")
     * @Annotations\QueryParam(name="code", requirements={"code : \d+"}, description="Get exchange rate for given currency code.")
     * @param string $code
     * @return View
     */
    public function geAverageCurrencyRate(string $code, CurrencyExchangeRateAverageQuery $currencyExchangeRateAverageQuery, Cache $cache)
    {
        $currencyAverageExchangeRate = $currencyExchangeRateAverageQuery->findOneByCurrencyCode($code);
        if ($currencyAverageExchangeRate) {
            $dto = new AverageCurrencyExchangeRateDto($currencyAverageExchangeRate);
            return View::create($dto->getData(), 200);
        }
        return View::create("Not found", 404);

    }
}
