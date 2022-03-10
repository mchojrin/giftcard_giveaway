<?php

namespace App\Repository;

use App\Entity\GiveAway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GiveAway|null find($id, $lockMode = null, $lockVersion = null)
 * @method GiveAway|null findOneBy(array $criteria, array $orderBy = null)
 * @method GiveAway[]    findAll()
 * @method GiveAway[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiveAwayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GiveAway::class);
    }

    // /**
    //  * @return GiveAway[] Returns an array of GiveAway objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GiveAway
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
