<?php

namespace App\Repository;

use App\Entity\Variants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Variants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Variants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Variants[]    findAll()
 * @method Variants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VariantsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Variants::class);
    }

//    /**
//     * @return Variants[] Returns an array of Variants objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Variants
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
