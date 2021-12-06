<?php

namespace App\Repository;

use App\Entity\SuiviActivite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SuiviActivite|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuiviActivite|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuiviActivite[]    findAll()
 * @method SuiviActivite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuiviActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuiviActivite::class);
    }

    // /**
    //  * @return SuiviActivite[] Returns an array of SuiviActivite objects
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
    public function findOneBySomeField($value): ?SuiviActivite
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
