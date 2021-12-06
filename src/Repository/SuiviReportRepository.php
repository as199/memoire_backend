<?php

namespace App\Repository;

use App\Entity\SuiviReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SuiviReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuiviReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuiviReport[]    findAll()
 * @method SuiviReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuiviReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuiviReport::class);
    }

    // /**
    //  * @return SuiviReport[] Returns an array of SuiviReport objects
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
    public function findOneBySomeField($value): ?SuiviReport
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
