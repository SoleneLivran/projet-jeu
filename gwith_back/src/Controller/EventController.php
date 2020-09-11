<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use App\Repository\EventRepository;
/**
 * @Route("/api/events")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="events_list", methods={"GET"})
     */
    public function list(EventRepository $repository)
    {
        $events = $repository->findAllOrderByName();
        return $this->json(
            $events,
            200,
            [],
            ["groups" => ["events:list"]]
        );
    }

    /**
     * @Route("/{id}", name="event_view" , methods={"GET"}, requirements={"id"="\d+"})
     */
    public function view(Event $event)
    {
        return $this->json(
            $event,
            200,
            [],
            ["groups" => ["event:view"]]
        );
    }

}
