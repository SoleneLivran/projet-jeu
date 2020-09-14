<?php

namespace App\Controller;

use App\Entity\Place;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlaceRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/places")
 * @IsGranted("ROLE_USER")
 */
class PlaceController extends AbstractController
{
    /**
     * @Route("/", name="places_list", methods={"GET"})
     */
    public function list(PlaceRepository $repository, Request $request)
    {
        if ($request->query->has('place_type')) {
            $placeType = $request->query->get('place_type');
            $places = $repository->findAllByType($placeType);
        } else {
            $places = $repository->findAllOrderByName();
        }
        return $this->json(
            $places,
            200,
            [],
            ["groups" => ["places:list"]]
        );
    }

    /**
     * @Route("/{id}", name="place_view", requirements={"id"="\d+"}, methods={"GET"})
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
