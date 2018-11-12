<h3> Simple currency aggreaging API, microservice </h3>
Application uses NBP api to download latest currency exchange rates and store in database.
There is CLI command for updating data in Database <br>
Just type: 

`bin/console app:download-current-currency-exchange-rates` <br>
Application uses Redis for caching so, it is nescessarry to run app properly.

Instalation is simple like standard Symfony4:
+ clone repo
+ `composer install`
+ setup porper credentials and ports in `.env`
+ then from command line `bin/console doctrine:database:create`
+ and from command line `bin/console doctrine:schema:update --force`

App should be ready to go:
there are 3 enpoints giving JSON in reponse:
+ `/api/exchange_rates/get_currency_codes`  return all currencies in database
+ `/api//exchange_rates/get_current_rate/{code}` return latest exchange rate for currency given as {code} param
+ `/api//exchange_rates/get_average_rate/{code}` return average exchange rate based on historical downloads for currency given as {code} param