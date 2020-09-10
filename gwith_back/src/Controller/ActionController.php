<?php

namespace App\Controller;

use App\Entity\Action;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActionRepository;

/**
 * @Route("/api/actions")
 */
class ActionController extends AbstractController
{
    /**
     * @Route("/", name="actions_list")
     */
    public function list(ActionRepository $repository)
    {
        $actions = $repository->findAllOrderByName();
        return $this->json(
            $actions,
            200,
            [],
            ["groups" => ["actions:list"]]
        );
    }

    /**
     * @Route("/{id}", name="action_view", requirements={"id"="\d+"})
     */
    public function view(Action $action)
    {
        return $this->json(
            $action,
            200,
            [],
            ["groups" => ["action:view"]]
        );
    }
}
