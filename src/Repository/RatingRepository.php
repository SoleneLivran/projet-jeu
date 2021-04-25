<?php

namespace App\Repository;

use App\Entity\Story;
use App\Entity\Rating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rating|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rating|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rating[]    findAll()
 * @method Rating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Rating::class);
        $this->manager = $manager;
    }

    public function ratingAverage($story)
    {
        $queryBuilder = $this->createQueryBuilder('rating');

        $queryBuilder->select("avg(rating.note)");
        $queryBuilder->join('rating.story', 'story');
        $queryBuilder->where('rating.story = :story');
        $queryBuilder->setParameter('story', $story);

        $query = $queryBuilder->getQuery();

        $result = $query->getOneOrNullResult();

        $rating = $result[1];
        $storyRating = $story->setRating($rating);
        $this->manager->persist($storyRating);
        $this->manager->flush();

        return $result;
    }
}
