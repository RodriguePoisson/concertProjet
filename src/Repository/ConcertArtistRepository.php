<?php

namespace App\Repository;

use App\Entity\ConcertArtist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConcertArtist|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConcertArtist|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConcertArtist[]    findAll()
 * @method ConcertArtist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcertArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConcertArtist::class);
    }

    // /**
    //  * @return ConcertArtist[] Returns an array of ConcertArtist objects
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
    public function findOneBySomeField($value): ?ConcertArtist
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
