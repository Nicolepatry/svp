<?php

namespace App\Repository;

use App\Entity\DepartementDesEntite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DepartementDesEntite|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepartementDesEntite|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepartementDesEntite[]    findAll()
 * @method DepartementDesEntite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartementDesEntiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepartementDesEntite::class);
    }

    // /**
    //  * @return DepartementDesEntite[] Returns an array of DepartementDesEntite objects
    //  */
  
    public function findBySuccursale($id_succursale)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.succursale = :val')
            ->setParameter('val', $id_succursale)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


  /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DepartementDesEntite
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
