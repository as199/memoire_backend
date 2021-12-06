<?php

namespace App\Repository;

use App\Entity\ReportingCodir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReportingCodir|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportingCodir|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportingCodir[]    findAll()
 * @method ReportingCodir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportingCodirRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportingCodir::class);
    }

    // /**
    //  * @return ReportingCodir[] Returns an array of ReportingCodir objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReportingCodir
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
