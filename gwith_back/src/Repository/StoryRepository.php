<?php

namespace App\Repository;

use App\Entity\Story;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Story|null find($id, $lockMode = null, $lockVersion = null)
 * @method Story|null findOneBy(array $criteria, array $orderBy = null)
 * @method Story[]    findAll()
 * @method Story[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Story::class);
    }

    /**
    * @return Story[] Returns an array of Story objects
    */

    public function findTopTen()
    {
        // de base ma requete ressemble à : SELECT * FROM story
        $queryBuilder = $this->createQueryBuilder('story');

         // je personnalise ma requete (ici max 10 résultats et ordonné par rating)
         $queryBuilder->setMaxResults(10);
         $queryBuilder->addOrderBy('story.rating');

         // j'éxécute ma requête
         $query = $queryBuilder->getQuery();

        // je m'attends à plusieurs resultats, donc : getResult() et non getOneOrNullResult()
        return $query->getResult();
    }


    public function findLatestTen()
    {
        // de base ma requete ressemble à : SELECT * FROM story
        $queryBuilder = $this->createQueryBuilder('story');

         // je personnalise ma requete (ici max 10 résultats et ordonné par date de publication)
         $queryBuilder->setMaxResults(10);
         $queryBuilder->addOrderBy('story.publishedAt');

         // j'éxécute ma requête
         $query = $queryBuilder->getQuery();

        // je m'attends à plusieurs resultats, donc : getResult() et non getOneOrNullResult()
        return $query->getResult();
    }
}
