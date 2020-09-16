<?php

namespace App\Controller;

use App\Repository\AppUserRepository;
use App\Entity\AppUser;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class UserAccountController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function createAccount(request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        $user = new AppUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $user = json_decode($request->getContent(), true);
        
        if($form->isValid()) {
            $plainPassword = $user->get('password')->getData();
            $encodedPassword = $passwordEncoder->encodePassword($user, $plainPassword);
            $user->setPassword($encodedPassword);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            return $this->json(
                [
                    "success" => true
                ],
                Response::HTTP_OK
            );
        }

        return $this->json(
            [
                "success" => false,
                "errors" => "Une erreur s'est produite lors de la création du compte"
            ],
            Response::HTTP_BAD_REQUEST
        );
    
    }

     /**
     * @Route("/account/delete", name="account_delete", requirements={"id"="\d+"})
     */
    public function delete()
    {
        /** @var AppUser $user */
        $user = $this->getUser();
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($user);
        $manager->flush();

        return $this->json(
            [
                "success" => true
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/account/change_password", name ="account_change_password")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(UserPasswordUpdateType::class, $user);
        $user = json_decode($request->getContent(), true);

        if($form->isValid()) {

            $plainPassword = $form->get('password')->getData();
            $encodedPassword = $passwordEncoder->encodePassword($user, $plainPassword); 
            $user->setPassword($encodedPassword);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            return $this->json(
                [
                    "success" => true
                ],
                Response::HTTP_OK
            );
        }

        return $this->json(
            [
                "success" => false,
                "errors" => "Une erreur s'est produite lors du changement de mot de passe"
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
