<?php

namespace App\Dto;


class PreparedCurrencyTableDto
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
    protected $rates;

    /**
     * PreparedCurrencyTableDto constructor.
     * @param string $table
     * @param string $no
     * @param string $effectiveDate
     * @param SingleCurrencyRateDto[] $rates
     */
    public function __construct(string $table, string $no, string $effectiveDate, array $rates)
    {
        $this->table = $table;
        $this->no = $no;
        $this->effectiveDate = $effectiveDate;
        $this->rates = $rates;
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
}