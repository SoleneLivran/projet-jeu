<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActionTypeRepository;


/**
 * @Route("/api/action_type")
 */
class ActionTypeController extends AbstractController
{
    /**
     * @Route("/", name="action_type_list", methods={"GET"})
     */
    public function list(ActionTypeRepository $repository)
    {
        $eventType = $repository->findAllOrderByName();
        return $this->json(
            $eventType,
            200,
            [],
            ["groups" => ["action_type:list"]]
        );
    }
}
