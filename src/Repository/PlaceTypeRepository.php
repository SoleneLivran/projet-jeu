<?php

namespace App\Repository;

use App\Entity\PlaceType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlaceType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlaceType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlaceType[]    findAll()
 * @method PlaceType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlaceType::class);
    }

    public function findAllOrderByName()
    {
        $queryBuilder = $this->createQueryBuilder('placeType');
        $queryBuilder->addOrderBy('placeType.name');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }
}
