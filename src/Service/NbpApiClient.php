<?php
namespace App\Service;

use App\Dto\PreparedCurrencyTableDto;
use App\Dto\RawCurrencyTableDto;
use App\Exceptions\DownloadCurrencyException;
use App\Service\Interfaces\CurrencyApiInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NbpApiClient
 * @package App\Service
 */
class NbpApiClient implements CurrencyApiInterface
{
    const CURRENCY_API_URL = 'http://api.nbp.pl/api/exchangerates/tables/{table}/';
    const DEFAULT_CURRENCY_FOR_SEARCH = 'USD';

    private $currencyTables = ['A', 'B'];

    /**
     * @param string $currency
     * @return string|null
     */
    public function getCurrentExchangeRateForCurrency(string $currency): ?string
    {
        // TODO: Implement getCurrentExchangeRateForCurrency() method.
    }

    /**
     * @return RawCurrencyTableDto[]|null
     */
    public function getCurrentExchangeRateForAllCurrencies(): ?array
    {
        $client = new Client();
        $result = [];
        foreach ($this->currencyTables as $table) {
            $url = str_replace('{table}', $table, self::CURRENCY_API_URL);

            try{
                $response = $client->get($url);
            } catch (ClientException $exception) {
                throw new DownloadCurrencyException('Url not found');
            }

            if ($response->getStatusCode() === Response::HTTP_OK && !empty($response->getBody())) {
                $responseContents = $response->getBody()->getContents();
                if (!empty($responseContents) && is_string($responseContents)) {
                    $result[] = $this->prepareResultDto($responseContents);
                }
            } else {
                throw new DownloadCurrencyException('Response is not valid');
            }
        }
        return $result;
    }

    /**
     * @param string $responseContents
     * @return PreparedCurrencyTableDto
     */
    protected function prepareResultDto(string $responseContents): PreparedCurrencyTableDto
    {
        $decodedApiData = json_decode($responseContents, true);
        $apiData = reset($decodedApiData);
        $rawCurrencyTableDto =
            new RawCurrencyTableDto($apiData);
        return $rawCurrencyTableDto->getPreparedCurrencyTableDto();
    }
}