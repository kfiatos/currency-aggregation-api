<?php

namespace App\Controller\Rest;

use App\Dto\Api\AverageCurrencyExchangeRateDto;
use App\Dto\Api\CurrentCurrencyExchangeRateDto;
use App\Service\CurrencyExchangeRateAverageQuery;
use App\Service\CurrencyExchangeRateQuery;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ExchangeRatesController
 * @package App\Controller\Rest
 */
class ExchangeRatesController extends AbstractController
{
    /**
     * @Annotations\Get("/exchange_rates/get_currency_codes")
     * @param CurrencyExchangeRateQuery $currencyExchangeRateQuery
     * @return View
     */
    public function getCurrencyCodes(CurrencyExchangeRateQuery $currencyExchangeRateQuery)
    {
        $currencyExchangeRates = $currencyExchangeRateQuery->findAllCurrencyCodes();
        if (empty($currencyExchangeRates)) {
            return View::create($currencyExchangeRates, Response::HTTP_NO_CONTENT);
        }
        return View::create($currencyExchangeRates, Response::HTTP_OK);
    }

    /**
     * @Annotations\Get("/exchange_rates/get_current_rate/{code}")
     * @Annotations\QueryParam(name="code", requirements={"code : \d+"}, description="Get exchange rate for given currency code.")
     * @param string $code
     * @param CurrencyExchangeRateQuery $currencyExchangeRateQuery
     * @return View
     */
    public function getCurrentCurrencyRate(string $code, CurrencyExchangeRateQuery $currencyExchangeRateQuery): View
    {
        $currencyExchangeRate = $currencyExchangeRateQuery->findOneByCurrencyCode($code);

        if ($currencyExchangeRate) {
            $dto = new CurrentCurrencyExchangeRateDto($currencyExchangeRate);
            return View::create($dto->getData(), Response::HTTP_OK);
        }
        return View::create("Not found", Response::HTTP_NO_CONTENT);
    }

    /**
     * @Annotations\Get("/exchange_rates/get_average_rate/{code}")
     * @Annotations\QueryParam(name="code", requirements={"code : \d+"}, description="Get exchange rate for given currency code.")
     * @param string $code
     * @param CurrencyExchangeRateAverageQuery $currencyExchangeRateAverageQuery
     * @return View
     */
    public function geAverageCurrencyRate(string $code, CurrencyExchangeRateAverageQuery $currencyExchangeRateAverageQuery)
    {
        $currencyAverageExchangeRate = $currencyExchangeRateAverageQuery->findOneByCurrencyCode($code);
        if ($currencyAverageExchangeRate) {
            $dto = new AverageCurrencyExchangeRateDto($currencyAverageExchangeRate);
            return View::create($dto->getData(), Response::HTTP_OK);
        }
        return View::create("Not found", Response::HTTP_NO_CONTENT);
    }
}
