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

    public function storyErrors(Story $story) : array
    {
        $errors = [];

        // ===========  if a transition in the story has no nextSceneId => error ================
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

        // echo $query->getSQL();die;

        $result = $query->getResult();

        if (count($result) > 0) {
            $errors[] = "Au moins une transition n'a pas de nextScene";
        }

        // ============= if a scene with event isEnd=false doesn't have a transition => error ===============
        // foreach


        // ============= if not at least one isEnd event => error =============
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

        if (count($result) <= 0) {
            $errors[] = "L'histoire doit avoir au moins une fin";
        }

        // ============= if a firstSceneId is null => error ==============
        if ($story->getFirstScene() == null) {
            // should not happen. If it does, only send this error at first to correct it before seeing if something else is broken
            $errors = [];
            $errors[] = "L'histoire n'a pas de scene de debut";
        }

        return $errors;
    }
}
