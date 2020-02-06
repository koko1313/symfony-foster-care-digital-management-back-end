<?php

namespace App\Repository;

use App\Entity\EmployeeOEPG;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EmployeeOEPG|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeOEPG|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeOEPG[]    findAll()
 * @method EmployeeOEPG[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeOEPGRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeOEPG::class);
    }

    // /**
    //  * @return EmployeeOEPG[] Returns an array of EmployeeOEPG objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EmployeeOEPG
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
