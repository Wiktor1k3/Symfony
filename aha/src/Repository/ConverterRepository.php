<?php

namespace App\Repository;

use App\Entity\Converter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Converter>
 *
 * @method Converter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Converter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Converter[]    findAll()
 * @method Converter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConverterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Converter::class);
    }

//    /**
//     * @return Converter[] Returns an array of Converter objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Converter
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
