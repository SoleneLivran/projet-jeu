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

    public function findAllOrderByTitle()
    {
        // my request here looks like : SELECT * FROM story
        $queryBuilder = $this->createQueryBuilder('story');
        
        $queryBuilder->where('story.status = 1');

        // customization of the request (ordered by title)
        $queryBuilder->addOrderBy('story.title');

           // execute request
        $query = $queryBuilder->getQuery();

        // I expect many results, so : getResult() and not getOneOrNullResult()
        return $query->getResult();
    }

    /**
    * @return Story[] Returns an array of Story objects
    */

    public function findAllByCategory($categoryId)
    {
        $queryBuilder = $this->createQueryBuilder('story');

        $queryBuilder->where('story.status = 1');

        $queryBuilder->leftJoin('story.category', 'storyCategory');

        $queryBuilder->andWhere(
            $queryBuilder->expr()->eq('storyCategory.id', $categoryId)
        );

        $queryBuilder->addOrderBy('story.title');

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function findAllByDifficulty($storyDifficulty)
    {
        $queryBuilder = $this->createQueryBuilder('story');

        $queryBuilder->where('story.status = 1');

        $queryBuilder->andWhere(
            $queryBuilder->expr()->eq('story.difficulty', $storyDifficulty)
        );

        $queryBuilder->addOrderBy('story.title');

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    /**
    * @return Story[] Returns an array of Story objects
    */

    public function findTopFive()
    {
        // my request here looks like : SELECT * FROM story
        $queryBuilder = $this->createQueryBuilder('story');

        $queryBuilder->where('story.status = 1');

         // je personnalise ma requete (ici max 10 résultats et ordonné par rating)
         $queryBuilder->setMaxResults(5);
         $queryBuilder->addOrderBy('story.rating');

         // execute the request
         $query = $queryBuilder->getQuery();

        // I expect many results, so : getResult() and not getOneOrNullResult()
        return $query->getResult();
    }

    /**
    * @return Story[] Returns an array of Story objects
    */

    public function findLatestFive()
    {
        // my request here looks like : SELECT * FROM story
        $queryBuilder = $this->createQueryBuilder('story');

        $queryBuilder->where('story.status = 1');
        
         // je personnalise ma requete (ici max 10 résultats et ordonné par date de publication)
         $queryBuilder->setMaxResults(5);
         $queryBuilder->addOrderBy('story.publishedAt');

         // execute the request
         $query = $queryBuilder->getQuery();

        // I expect many results, so : getResult() and not getOneOrNullResult()
        return $query->getResult();
    }

    // ===== Checks : is story playable? =====

    public function doesStoryHasFirstScene(Story $story) : bool
    {
        if ($story->getFirstScene() == null) {
            return false;
        }

        return true;
    }

    public function doesStoryHasEnd(Story $story) : bool
    {
        // we check the events of the current story
        $queryBuilder = $this->createQueryBuilder('story');
        $queryBuilder->join('story.scenes', 'scene');
        $queryBuilder->join('scene.event', 'event');


        $queryBuilder->where('story = :story');
        // find isEnd = true
        $queryBuilder->andWhere('event.isEnd = true');

        $queryBuilder->setParameter('story', $story);

        // execute request
        $query = $queryBuilder->getQuery();
        $result = $query->getResult();

        // if no isEnd=true found :
        if (count($result) <= 0) {
            return false;
        }

        return true;
    }

    public function doNonEndScenesHaveTransitions(Story $story) : bool
    {
        // For each scene...
        foreach ($story->getScenes() as $scene) {
            // if it's not the story's end...
            if (!$scene->getEvent()->getIsEnd()) {
                // do we have at least 1 transition?
                if ($scene->getTransitions()->count() <= 0) {
                    return false;
                }
            }
        }

        return true;
    }

    public function doTransitionsHaveNextScene(Story $story) : bool
    {
        // we check the transitions of the current story
        $queryBuilder = $this->createQueryBuilder('story');
        $queryBuilder->join('story.scenes', 'scene');
        $queryBuilder->join('scene.transitions', 'transition');

        $queryBuilder->where('story = :story');
        // find null nextScene
        $queryBuilder->andWhere('transition.nextScene is NULL');

        $queryBuilder->setParameter('story', $story);

        // execute request
        $query = $queryBuilder->getQuery();

        $result = $query->getResult();

        if (count($result) > 0) {
            return false;
        }

        return true;
    }
}
