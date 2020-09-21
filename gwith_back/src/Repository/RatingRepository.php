<?php

namespace App\Repository;

use App\Entity\Story;
use App\Entity\Rating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rating|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rating|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rating[]    findAll()
 * @method Rating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rating::class);
    }

    public function ratingAverage($story)
    {
        $queryBuilder = $this->createQueryBuilder('rating');

        $queryBuilder->select("avg(rating.note)")->where(
            $queryBuilder->expr()->eq('rating.story', $story)
        );

        $queryBuilder->leftJoin('story.name', 'story');
        $queryBuilder->addSelect('story');

        $query = $queryBuilder->getQuery();

        $result = $query->getOneOrNullResult();

        $story->setRating($result);

        return $result;
    }
}
