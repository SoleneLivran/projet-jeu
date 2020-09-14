<?php

namespace App\Controller;

use App\Entity\AppUser;
use App\Repository\AppUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/api/app_users")
 * @IsGranted("ROLE_USER")
 */
class AppUserController extends AbstractController
{
    /**
     * @Route("/", name="app_users_list", methods={"GET"})
     */
    public function list(AppUserRepository $repository)
    {
        $appUsers = $repository->findAllOrderByName();

        return $this->json(
            $appUsers,
            200,
            [],
            ["groups" => ["app_users:list"]]
        );
    }

    /**
     * @Route("/{id}", name="app_user_view", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function view(AppUser $appUser)
    {
        return $this->json(
            $appUser,
            200,
            [],
            ["groups" => ["app_users:view"]]
        );
    }
}
