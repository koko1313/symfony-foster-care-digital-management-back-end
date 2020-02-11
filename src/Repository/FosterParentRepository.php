<?php

namespace App\Repository;

use App\Entity\FosterParent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FosterParent|null find($id, $lockMode = null, $lockVersion = null)
 * @method FosterParent|null findOneBy(array $criteria, array $orderBy = null)
 * @method FosterParent[]    findAll()
 * @method FosterParent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FosterParentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FosterParent::class);
    }

    // /**
    //  * @return FosterParent[] Returns an array of FosterParent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FosterParent
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
