<?php

namespace App\Repository;

use App\Entity\Employer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Employer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employer[]    findAll()
 * @method Employer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employer::class);
    }



    public function findByEntite($id_departement)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.departement = :val')
            ->setParameter('val', $id_departement)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Employer[] Returns an array of Employer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Employer
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
