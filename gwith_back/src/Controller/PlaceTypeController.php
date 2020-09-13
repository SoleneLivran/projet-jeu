<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlaceTypeRepository;

/**
 * @Route("/api/place_types")
 */
class PlaceTypeController extends AbstractController
{
    /**
     * @Route("/", name="place_types_list", methods={"GET"})
     */
    public function list(PlaceTypeRepository $repository)
    {
        $placeType = $repository->findAllOrderByName();
        return $this->json(
            $placeType,
            200,
            [],
            ["groups" => ["placeTypes:list"]]
        );
    }
}
