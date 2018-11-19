<?php

namespace App\Controller\Web;

use App\CommandBus\Commands\DownloadCurrentCurrencyExchangeRatesCommand;
use App\Exceptions\DownloadCurrencyException;
use App\Service\CurrencyExchangeRateQuery;
use FOS\RestBundle\View\View;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/", name="test")
     * @param CommandBus $commandBus
     * @return Response
     */
    public function index(CommandBus $commandBus, CurrencyExchangeRateQuery $currencyExchangeRateQuery)
    {
        $currencyExchangeRates = $currencyExchangeRateQuery->findAllCurrencyCodes();
//        return View::create($currencyExchangeRates, Response::HTTP_OK);
//        die;

//        $command = new DownloadCurrentCurrencyExchangeRatesCommand();
//        try {
//            $commandBus->handle($command);
//        }catch (DownloadCurrencyException $exception) {
//            //silence
//        }

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'rates' => $currencyExchangeRates
        ]);
    }
}
