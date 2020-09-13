<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
    * @return Event[] Returns an array of Event objects
    */

    public function findAllOrderByName()
    {
        // de base ma requete ressemble à : SELECT * FROM story
        $queryBuilder = $this->createQueryBuilder('event');

         // je personnalise ma requete (ordonné par titre)
         $queryBuilder->addOrderBy('event.name');

         // j'éxécute ma requête
         $query = $queryBuilder->getQuery();

        // je m'attends à plusieurs resultats, donc : getResult() et non getOneOrNullResult()
        return $query->getResult();
    }

    public function findAllByType($typeId)
    {
        $queryBuilder = $this->createQueryBuilder('event');
        // join the actionType table
        // first arg : foreign key / relation we want to follow
        // 2nd arg : alias
        $queryBuilder->leftJoin('event.eventType', 'eventType');
        // where action.type.id == typeId
        $queryBuilder->where(
            $queryBuilder->expr()->eq('eventType.id', $typeId)
        );
         $queryBuilder->addOrderBy('event.name');
         $query = $queryBuilder->getQuery();
        return $query->getResult();
    }


}
