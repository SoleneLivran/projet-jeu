<?php

namespace App\Controller;

use App\Entity\Transition;
use App\Repository\SceneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Scene;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
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
