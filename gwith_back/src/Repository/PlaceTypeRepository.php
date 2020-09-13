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
        // de base ma requete ressemble à : SELECT * FROM place
        $queryBuilder = $this->createQueryBuilder('placeType');

         // je personnalise ma requete (ordonné par titre)
         $queryBuilder->addOrderBy('placeType.name');

         // j'éxécute ma requête
         $query = $queryBuilder->getQuery();

        // je m'attends à plusieurs resultats, donc : getResult() et non getOneOrNullResult()
        return $query->getResult();
    }
}
