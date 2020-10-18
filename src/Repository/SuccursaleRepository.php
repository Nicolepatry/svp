<?php

namespace App\Repository;

use App\Entity\Succursale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Succursale|null find($id, $lockMode = null, $lockVersion = null)
 * @method Succursale|null findOneBy(array $criteria, array $orderBy = null)
 * @method Succursale[]    findAll()
 * @method Succursale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuccursaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Succursale::class);
    }
    
    // /**
    //  * @return Succursale[] Returns an array of Succursale objects
    //  */

    public function findByEntite($id_entite)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.entite = :val')
            ->setParameter('val', $id_entite)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    






    
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
    public function findOneBySomeField($value): ?Succursale
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
