<?php

namespace App\Repository;

use App\Entity\ConcertBand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
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

    /**
    * @return ConcertBand[] Returns an array of ConcertConcert objects
    */
    public function getBandInLimit($start,$end)
    {
        $rsm =  new ResultSetMapping($this->getEntityManager());
        $rsm->addEntityResult(ConcertBand::class,'band');
        $rsm->addFieldResult('band', 'id', 'id');
        $rsm->addFieldResult('band', 'description', 'description');
        $rsm->addFieldResult('band', 'picture', 'picture');
        $rsm->addFieldResult('band', 'name', 'name');
        

        $sql = 'SELECT * FROM concert_band LIMIT :start,:end';

        $query = $this->getEntityManager()->createNativeQuery($sql,$rsm);
        
        $parameters = ['start'=>$start,'end'=>$end];
        $query->setParameters($parameters);
    
        $bands = $query->getResult();
        return $bands;
    }

    public function getBandCount()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(band.id)');
        $qb->from(ConcertBand::class,'band');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getBandCountByUser(String $id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT COUNT(*)
            FROM concert_band band
            JOIN user_concert_band favorite ON favorite.concert_band_id = band.id
            WHERE favorite.user_id = :id
        ';
        $stmt = $conn->prepare($sql);

        $stmt->executeQuery(['id' => $id]);

        return $stmt->fetch();
    }

    /**
    * @return ConcertBand[] Returns an array of ConcertBand objects
    */
    public function getFavoriteBand($id,$start,$end)
    {
        $rsm =  new ResultSetMapping($this->getEntityManager());
        $rsm->addEntityResult(ConcertBand::class,'band');
        $rsm->addFieldResult('band', 'id', 'id');
        $rsm->addFieldResult('band', 'description', 'description');
        $rsm->addFieldResult('band', 'picture', 'picture');
        $rsm->addFieldResult('band', 'name', 'name');

        $sql = 'SELECT *
                FROM concert_band band
                JOIN user_concert_band favorite ON favorite.concert_band_id = band.id
                WHERE favorite.user_id = :id
                LIMIT :start,:end';

        $query = $this->getEntityManager()->createNativeQuery($sql,$rsm);
        
        $parameters = ['id'=>$id,'start'=>$start,'end'=>$end];
        $query->setParameters($parameters);
    
        $bands = $query->getResult();
        return $bands;
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
