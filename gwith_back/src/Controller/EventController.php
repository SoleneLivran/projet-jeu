<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * @Route("/api/events")
 * @IsGranted("ROLE_USER")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="events_list", methods={"GET"})
     */
    public function list(EventRepository $repository, Request $request)
    {
       if ($request->query->has('event_type')) {
        $eventType = $request->query->get('event_type');
        $events = $repository->findAllByType($eventType);
    } else {
        $events = $repository->findAllOrderByName();
    }

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
