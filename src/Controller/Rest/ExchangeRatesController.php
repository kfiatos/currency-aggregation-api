<?php

namespace App\Controller\Rest;

use App\CommandBus\Commands\DownloadCurrentCurrencyExchangeRatesCommand;
use App\Exceptions\DownloadCurrencyException;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExchangeRatesController extends AbstractController
{
    /**
     * @Route("/exchange_rates/get_currency_codes", name="api_get_currency_codes")
     * @param CommandBus $commandBus
     * @return Response
     */
    public function index(CommandBus $commandBus)
    {
        $command = new DownloadCurrentCurrencyExchangeRatesCommand();
        try {
            $commandBus->handle($command);
        }catch (DownloadCurrencyException $exception) {
            //silence
        }


        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
