<?php

namespace App\Repository;

use App\Entity\LigneCommandeFleur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LigneCommandeFleur|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneCommandeFleur|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneCommandeFleur[]    findAll()
 * @method LigneCommandeFleur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneCommandeFleurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneCommandeFleur::class);
    }

    // /**
    //  * @return LigneCommandeFleur[] Returns an array of LigneCommandeFleur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LigneCommandeFleur
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
