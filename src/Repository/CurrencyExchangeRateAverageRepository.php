<?php

namespace App\Repository;

use App\Entity\CurrencyExchangeRateAverage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CurrencyExchangeRateAverage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrencyExchangeRateAverage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrencyExchangeRateAverage[]    findAll()
 * @method CurrencyExchangeRateAverage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyExchangeRateAverageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CurrencyExchangeRateAverage::class);
    }

    /**
     * @param string $currencyCode
     * @return CurrencyExchangeRateAverage|null
     */
    public function findOneByCurrencyCode(string $currencyCode): ?CurrencyExchangeRateAverage
    {
        $averageExchangeRate = $this->findOneBy(
            ['currencyCode' => $currencyCode]
        );
        return $averageExchangeRate;
    }

    /**
     * @param CurrencyExchangeRateAverage $entity
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function store(CurrencyExchangeRateAverage $entity): bool
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return true;
    }
}
