<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyExchangeRateRepository")
 * @ORM\Table(name="currency_exchange_rate",uniqueConstraints={@ORM\UniqueConstraint(name="currency_code_effective_date_unique_idx", columns={"currency_code", "effective_date"})})
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class CurrencyExchangeRate
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
    private $currency_code;

    /**
     * @ORM\Column(type="decimal", precision=9, scale=6)
     */
    private $rate;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private $currency_description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $effective_date;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $currency_table;

    /**
     * @ORM\Column(type="integer")
     */
    private $computed_count = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_date;

    /**
     * CurrencyRate constructor.
     */
    public function __construct()
    {
        $this->updated_date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->currency_code;
    }

    public function setCurrencyCode(string $currency_code): self
    {
        $this->currency_code = $currency_code;

        return $this;
    }

    public function getCurrencyDescription(): ?string
    {
        return $this->currency_description;
    }

    public function setCurrencyDescription(?string $currency_description): self
    {
        $this->currency_description = $currency_description;

        return $this;
    }

    public function getEffectiveDate(): ?\DateTime
    {
        return $this->effective_date;
    }

    public function setEffectiveDate(\DateTimeInterface $effective_date): self
    {
        $this->effective_date = $effective_date;

        return $this;
    }

    public function getCurrencyTable(): ?string
    {
        return $this->currency_table;
    }

    public function setCurrencyTable(?string $currency_table): self
    {
        $this->currency_table = $currency_table;

        return $this;
    }

    public function getUpdatedDate(): ?\DateTimeInterface
    {
        return $this->updated_date;
    }

    public function setUpdatedDate(\DateTimeInterface $updated_date): self
    {
        $this->updated_date = $updated_date;

        return $this;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate($rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return integer
     */
    public function getComputedCount(): int
    {
        return $this->computed_count;
    }

    /**
     * @return CurrencyExchangeRate
     */
    public function incrementComputedCount(): self
    {
        $this->computed_count++;
        return $this;
    }
}
