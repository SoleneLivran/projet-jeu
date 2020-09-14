<?php

namespace App\Repository;

use App\Entity\Action;
use App\Entity\ActionType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Action|null find($id, $lockMode = null, $lockVersion = null)
 * @method Action|null findOneBy(array $criteria, array $orderBy = null)
 * @method Action[]    findAll()
 * @method Action[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Action::class);
    }

    /**
    * @return Action[] Returns an array of Action objects
    */

    public function findAllOrderByName()
    {
        $queryBuilder = $this->createQueryBuilder('action');

         $queryBuilder->addOrderBy('action.name');

         $query = $queryBuilder->getQuery();

        return $query->getResult();
    }


    public function findAllByType($typeId)
    {
        $queryBuilder = $this->createQueryBuilder('action');

        // join the actionType table
        // first arg : foreign key / relation we want to follow
        // 2nd arg : alias
        $queryBuilder->leftJoin('action.actionType', 'actionType');

        // where action.type.id == typeId
        $queryBuilder->where(
            $queryBuilder->expr()->eq('actionType.id', $typeId)
        );

         $queryBuilder->addOrderBy('action.name');

         $query = $queryBuilder->getQuery();

        return $query->getResult();
    }


}
