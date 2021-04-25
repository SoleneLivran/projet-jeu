<?php

namespace App\Controller;

use App\Entity\Avatar;
use App\Repository\AvatarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/avatars")
 * @IsGranted("ROLE_USER")
 */
class AvatarController extends AbstractController
{
    /**
     * @Route("/", name="avatars_list", methods={"GET"})
     */
    public function list(AvatarRepository $repository)
    {
        $avatars = $repository->findAll();

        return $this->json(
            $avatars,
            200,
            [],
            ["groups" => ["avatars:list"]]
        );
    }

    /**
     * @Route("/{id}", name="avatar_view", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function view(Avatar $avatar)
    {
        return $this->json(
            $avatar,
            200,
            [],
            ["groups" => ["avatar:view"]]
        );
    }
}
