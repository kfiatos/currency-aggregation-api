<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="CurrencyExchangeRateAverageRepository")
 * @ORM\Table(name="currency_exchange_rate_average",uniqueConstraints={@ORM\UniqueConstraint(name="currency_code_effective_date_unique_idx", columns={"currency_code", "effective_date"})})
 */
class CurrencyExchangeRateAverage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $currencyCode;

    /**
     * @ORM\Column(type="decimal", precision=9, scale=6)
     */
    private $averageRate = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    private $effectiveDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedDate;

    public function __construct()
    {
        $this->updatedDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    /**
     * @return int|float
     */
    public function getAverageRate(): float
    {
        return $this->averageRate;
    }

    public function setAverageRate($averageRate): self
    {
        $this->averageRate = $averageRate;

        return $this;
    }

    public function getUpdatedDate(): ?\DateTimeInterface
    {
        return $this->updatedDate;
    }

    public function setUpdatedDate(\DateTimeInterface $updatedDate): self
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEffectiveDate(): \DateTime
    {
        return $this->effectiveDate;
    }

    /**
     * @param \DateTime $effectiveDate
     * @return CurrencyExchangeRateAverage
     */
    public function setEffectiveDate(\DateTime $effectiveDate): self
    {
        $this->effectiveDate = $effectiveDate;

        return $this;
    }
}
