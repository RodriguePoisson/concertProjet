<?php

namespace App\Repository;

use App\Entity\ConcertArtist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
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
    /**
    * @return ConcertArtist[] Returns an array of ConcertConcert objects
    */
    public function getArtistInLimit($start,$end)
    {
        $rsm =  new ResultSetMapping($this->getEntityManager());
        $rsm->addEntityResult(ConcertArtist::class,'artist');
        $rsm->addFieldResult('artist', 'id', 'id');
        $rsm->addFieldResult('artist', 'biography', 'biography');
        $rsm->addFieldResult('artist', 'picture', 'picture');
        $rsm->addFieldResult('artist', 'name', 'name');
        $rsm->addFieldResult('artist', 'last_name', 'last_name');
        $rsm->addFieldResult('artist', 'pseudo', 'pseudo');
        

        $sql = 'SELECT * FROM concert_artist LIMIT :start,:end';

        $query = $this->getEntityManager()->createNativeQuery($sql,$rsm);
        
        $parameters = ['start'=>$start,'end'=>$end];
        $query->setParameters($parameters);
    
        $bands = $query->getResult();
        return $bands;
    }

    public function getArtistCount()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(artist.id)');
        $qb->from(ConcertArtist::class,'artist');

        return $qb->getQuery()->getSingleScalarResult();
    }
    public function getArtistCountByUser(String $id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT COUNT(*)
            FROM concert_artist artist
            JOIN user_concert_artist favorite ON favorite.concert_artist_id = artist.id
            WHERE favorite.user_id = :id
        ';
        $stmt = $conn->prepare($sql);

        $stmt->executeQuery(['id' => $id]);

        return $stmt->fetch();
    }

    /**
    * @return ConcertArtist[] Returns an array of ConcertArtist objects
    */
    public function getFavoriteArtist($id,$start,$end)
    {
        $rsm =  new ResultSetMapping($this->getEntityManager());
        $rsm->addEntityResult(ConcertArtist::class,'artist');
        $rsm->addFieldResult('artist', 'id', 'id');
        $rsm->addFieldResult('artist', 'description', 'description');
        $rsm->addFieldResult('artist', 'picture', 'picture');
        $rsm->addFieldResult('artist', 'name', 'name');

        $sql = 'SELECT *
                FROM concert_artist artist
                JOIN user_concert_artist favorite ON favorite.concert_artist_id = artist.id
                WHERE favorite.user_id = :id
                LIMIT :start,:end';

        $query = $this->getEntityManager()->createNativeQuery($sql,$rsm);
        
        $parameters = ['id'=>$id,'start'=>$start,'end'=>$end];
        $query->setParameters($parameters);
    
        $artists = $query->getResult();
        return $artists;
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
