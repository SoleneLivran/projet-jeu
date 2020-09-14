<?php

namespace App\Controller;

use App\Entity\Action;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActionRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/actions")
 * @IsGranted("ROLE_USER")
 */
class ActionController extends AbstractController
{
    /**
     * @Route("/", name="actions_list", methods={"GET"})
     */
    public function list(ActionRepository $repository, Request $request)
    {
        if ($request->query->has('action_type')) {
            $actionTypes = $request->query->get('action_type');
            $actions = $repository->findAllByType($actionTypes);

        } else {
            $actions = $repository->findAllOrderByName();
        }
        return $this->json(
            $actions,
            200,
            [],
            ["groups" => ["actions:list"]]
        );
    }

    /**
     * @Route("/{id}", name="action_view", methods={"GET"}, requirements={"id"="\d+"})
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
