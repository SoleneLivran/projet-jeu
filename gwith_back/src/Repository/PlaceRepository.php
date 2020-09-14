<?php

namespace App\Repository;

use App\Entity\Place;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Place|null find($id, $lockMode = null, $lockVersion = null)
 * @method Place|null findOneBy(array $criteria, array $orderBy = null)
 * @method Place[]    findAll()
 * @method Place[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Place::class);
    }

    /**
    * @return Place[] Returns an array of Place objects
    */
    
    public function findAllOrderByName()
    {
        // de base ma requete ressemble à : SELECT * FROM place
        $queryBuilder = $this->createQueryBuilder('place');

         // je personnalise ma requete (ordonné par titre)
         $queryBuilder->addOrderBy('place.name');

         // j'éxécute ma requête
         $query = $queryBuilder->getQuery();

        // je m'attends à plusieurs resultats, donc : getResult() et non getOneOrNullResult()
        return $query->getResult();
    }

    public function findAllByType($typeId)
    {
        $queryBuilder = $this->createQueryBuilder('place');
      
        $queryBuilder->leftJoin('place.placeType', 'placeType');
        
        $queryBuilder->where(
            $queryBuilder->expr()->eq('placeType.id', $typeId)
        );
         $queryBuilder->addOrderBy('place.name');
         $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

}
