<?php

namespace App\Controller;

use App\Entity\Place;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlaceRepository;

/**
 * @Route("/api/places")
 */
class PlaceController extends AbstractController
{
    /**
     * @Route("/", name="places_list")
     */
    public function list(PlaceRepository $repository)
    {
        $places = $repository->findAllOrderByName();
        return $this->json(
            $places,
            200,
            [],
            ["groups" => ["places:list"]]
        );
    }

    /**
     * @Route("/{id}", name="place_view", requirements={"id"="\d+"})
     */
    public function view(Place $place)
    {
        return $this->json(
            $place,
            200,
            [],
            ["groups" => ["place:view"]]
        );
    }
}
