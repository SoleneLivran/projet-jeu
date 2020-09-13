<?php

namespace App\Controller;

use App\Repository\EventTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/api/event_type")
 */
class EventTypeController extends AbstractController
{
    /**
     * @Route("/", name="event_type_list", methods={"GET"})
     */
    public function list(EventTypeRepository $repository)
    {
        $eventType = $repository->findAllOrderByName();
        return $this->json(
            $eventType,
            200,
            [],
            ["groups" => ["event_type:list"]]
        );
    }

}

