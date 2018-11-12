<?php

namespace App\Repository;

use App\Dto\PreparedCurrencyTableDto;
use App\Dto\SingleCurrencyRateDto;
use App\Entity\CurrencyExchangeRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CurrencyExchangeRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrencyExchangeRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrencyExchangeRate[]    findAll()
 * @method CurrencyExchangeRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyExchangeRateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CurrencyExchangeRate::class);
    }

    /**
     * @param PreparedCurrencyTableDto $dto
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function storeByDto(PreparedCurrencyTableDto $dto)
    {
        // This is pretty slow solution but simple and will be done only once a day
        // and for about 200 rows
        /** @var SingleCurrencyRateDto $rate */
        foreach ($dto->getRates() as $rate) {
            $currencyRate = $this->findOneBy(
                ['currency_code' => $rate->getCurrencyCode()]
            );
            if ($currencyRate) {
                $currencyRate
                    ->setRate($rate->getConversionRate())
                    ->setEffectiveDate(new \DateTime($dto->getEffectiveDate()));
            } else {
                $currencyRate = new CurrencyExchangeRate();
                $currencyRate
                    ->setCurrencyCode($rate->getCurrencyCode())
                    ->setCurrencyDescription($rate->getCurrencyDescription())
                    ->setRate($rate->getConversionRate())
                    ->setCurrencyTable($dto->getTable())
                    ->setEffectiveDate(new \DateTime($dto->getEffectiveDate()));
            }
            $this->getEntityManager()->persist($currencyRate);
        }
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $currencyCode
     * @param string $effectiveDate
     * @return CurrencyExchangeRate
     */
    public function findOneByCurrencyCodeAndEffectiveDate(string $currencyCode, string $effectiveDate)
    {
        $currencyExchangeRate = $this->findOneBy(
            [
                'currency_code' => $currencyCode,
                'effective_date' => new \DateTime($effectiveDate),
            ]
        );

        return $currencyExchangeRate;
    }

    /**
     * @param string $currencyCode
     * @return CurrencyExchangeRate|null
     */
    public function findOneByCurrencyCode(string $currencyCode): ?CurrencyExchangeRate
    {
        $currencyExchangeRate = $this->findOneBy(
            ['currency_code' => $currencyCode]
        );
        return $currencyExchangeRate;
    }

    /**
     * @param int $id
     * @return CurrencyExchangeRate|null
     */
    public function findOneById(int $id): ?CurrencyExchangeRate
    {
        return $this->findOneBy(
            ['id' => $id]
        );
    }

    /**
     * @return array
     */
    public function findAllCurrencyCodes(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->select(['c.currency_description as currency, c.currency_code as code'])
            ->getQuery()->getArrayResult();

        return $qb;
    }

    /**
     * @param CurrencyExchangeRate $currencyExchangeRate
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function store(CurrencyExchangeRate $currencyExchangeRate)
    {
        $this->getEntityManager()->persist($currencyExchangeRate);
        $this->getEntityManager()->flush();
    }
}
