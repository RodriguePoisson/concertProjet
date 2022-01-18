<?php

namespace App\Repository;

use App\Entity\ConcertBand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConcertBand|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConcertBand|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConcertBand[]    findAll()
 * @method ConcertBand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcertBandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConcertBand::class);
    }

    // /**
    //  * @return ConcertBand[] Returns an array of ConcertBand objects
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
    public function findOneBySomeField($value): ?ConcertBand
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
