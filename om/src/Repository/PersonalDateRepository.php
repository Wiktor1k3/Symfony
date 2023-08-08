<?php

namespace App\Repository;

use App\Entity\PersonalDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonalDate>
 *
 * @method PersonalDate|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonalDate|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonalDate[]    findAll()
 * @method PersonalDate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalDateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonalDate::class);
    }

    public function findByUser($user): ?PersonalDate
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }
//    /**
//     * @return PersonalDate[] Returns an array of PersonalDate objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PersonalDate
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
