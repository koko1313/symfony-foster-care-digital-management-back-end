<?php

namespace App\Repository;

use App\Entity\SubRegion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SubRegion|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubRegion|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubRegion[]    findAll()
 * @method SubRegion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubRegionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubRegion::class);
    }

    // /**
    //  * @return SubRegion[] Returns an array of SubRegion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubRegion
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
