<?php

namespace App\Controller\Rest;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ExchangeRatesController
 * @package App\Controller\Rest
 */
class ExchangeRatesController extends AbstractController
{
    /**
     * @Annotations\Get("/exchange_rates/get_currency_codes")
     */
    public function getCurrencyCodes(Request $request)
    {

        return View::create(3, 200);

    }
}
