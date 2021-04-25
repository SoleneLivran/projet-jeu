<?php

namespace App\Controller;

use App\Entity\AppUser;
use App\Entity\Story;
use App\Repository\AppUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/api/app_users")
 * @IsGranted("ROLE_USER")
 */
class AppUserController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    /**
     * @Route("/", name="app_users_list", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
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
        $connectedUser = $this->security->getUser();

        if ($connectedUser->getId() == $appUser->getId()) {
            return $this->json(
                $appUser,
                200,
                [],
                ["groups" => ["app_user:view"]]
            );
        } else {
            return $this->json(
                [
                "success" => false
                ],
                Response::HTTP_FORBIDDEN
            );
        }
    }

    /**
     * @Route("/{id}/stories", name="app_user_view_stories", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function viewStories(AppUser $appUser)
    {
        $connectedUser = $this->security->getUser();

        if ($connectedUser->getId() == $appUser->getId()) {
            $appUserStories = $appUser->getStories();
            return $this->json(
                $appUserStories,
                200,
                [],
                ["groups" => ["stories:view_user_stories"]]
            );
        } else {
            return $this->json(
                [
                "success" => false
                ],
                Response::HTTP_FORBIDDEN
            );
        }
    }
}
