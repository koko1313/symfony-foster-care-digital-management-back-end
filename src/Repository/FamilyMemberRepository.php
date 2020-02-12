<?php

namespace App\Repository;

use App\Entity\FamilyMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FamilyMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilyMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilyMember[]    findAll()
 * @method FamilyMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilyMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilyMember::class);
    }

    // /**
    //  * @return FamilyMember[] Returns an array of FamilyMember objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FamilyMember
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}