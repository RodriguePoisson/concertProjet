<?php

namespace App\Repository;

use App\Entity\ConcertConcert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConcertConcert|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConcertConcert|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConcertConcert[]    findAll()
 * @method ConcertConcert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcertConcertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConcertConcert::class);
    }

    /**
    * @return ConcertConcert[] Returns an array of ConcertConcert objects
    */
    public function getConcertInLimit($start,$end)
    {
        $rsm =  new ResultSetMapping($this->getEntityManager());
        $rsm->addEntityResult(ConcertConcert::class,'concert');
        $rsm->addFieldResult('concert', 'id', 'id');
        $rsm->addFieldResult('concert', 'description', 'description');
        $rsm->addFieldResult('concert', 'picture', 'picture');
        $rsm->addFieldResult('concert', 'date', 'date');
        $rsm->addFieldResult('concert', 'duration', 'duration');
        

        $sql = 'SELECT * FROM concert_concert LIMIT :start,:end';

        $query = $this->getEntityManager()->createNativeQuery($sql,$rsm);
        
        $parameters = ['start'=>$start,'end'=>$end];
        $query->setParameters($parameters);
    
        $concerts = $query->getResult();
        return $concerts;
    }

    public function getConcertCount()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(concert.id)');
        $qb->from(ConcertConcert::class,'concert');

        return $qb->getQuery()->getSingleScalarResult();
    }

    // /**
    //  * @return ConcertConcert[] Returns an array of ConcertConcert objects
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
    public function findOneBySomeField($value): ?ConcertConcert
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
