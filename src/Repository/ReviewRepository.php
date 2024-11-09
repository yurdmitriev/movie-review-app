<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    /**
     * @return Review[]
     */
    public function findByMovie(int $movieId, bool $isApproved = true, int $limit = 0, int $page = 1): array
    {
        $qb = $this->createQueryBuilder('r')
            ->andWhere('r.movie_id = :movie')
            ->setParameter('movie', $movieId, \Doctrine\DBAL\ParameterType::INTEGER);

        if ($isApproved) {
            $qb->andWhere('r.is_approved = :approved')
                ->setParameter('approved', true, \Doctrine\DBAL\ParameterType::BOOLEAN);
        }

        if ($limit > 0) {
            $qb->setMaxResults($limit);
        }

        if ($page > 1 && $limit > 0) {
            $qb->setFirstResult($page * $limit);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Review[] Returns an array of Review objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Review
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
