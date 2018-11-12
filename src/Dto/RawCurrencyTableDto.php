<?php

namespace App\Dto;

/**
 * Class CurrencyTableDto
 * @package App\Dto
 */
final class RawCurrencyTableDto
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $no;

    /**
     * @var string
     */
    protected $effectiveDate;

    /**
     * @var SingleCurrencyRateDto[]
     */
    protected $rates = [];


    public function __construct(array $currencyTable)
    {
        $this->table = $currencyTable['table'];
        $this->no = $currencyTable['no'];
        $this->effectiveDate = $currencyTable['effectiveDate'];
        foreach ($currencyTable['rates'] as $rate) {
            $this->rates[] = new SingleCurrencyRateDto($rate);
        }
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getNo(): string
    {
        return $this->no;
    }

    /**
     * @return string
     */
    public function getEffectiveDate(): string
    {
        return $this->effectiveDate;
    }

    /**
     * @return SingleCurrencyRateDto[]
     */
    public function getRates(): array
    {
        return $this->rates;
    }

    /**
     * @return PreparedCurrencyTableDto
     */
    public function getPreparedCurrencyTableDto()
    {
        return new PreparedCurrencyTableDto(
            $this->getTable(),
            $this->getNo(),
            $this->getEffectiveDate(),
            $this->getRates()
        );
    }
}