<?php

namespace App\Controller;

use App\Entity\Transition;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * @IsGranted("ROLE_USER")
 */
class SceneController extends AbstractController
{
    /**
     * @Route("/transitions/{id}/next_scene", name="next_scene")
     */
    public function getNextScene(Transition $transition)
    {
        $scene = $transition->getNextScene();

        return $this->json(
            $scene,
            200,
            [],
            ["groups" => ["next_scene"]]
        );
    }
}
