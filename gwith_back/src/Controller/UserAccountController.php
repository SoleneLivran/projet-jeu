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
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
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
                "errors" => "Une erreur s'est produite lors de la création du compte"
            ],
            Response::HTTP_BAD_REQUEST
        );
    
    }

     /**
     * @Route("/account/delete", name="account_delete")
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
     * @Route("/account/password_update", name ="account_password_update")
     */
    public function passwordUpdate(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        /** @var AppUser $user */
        $user = $this->getUser();
        $form = $this->createForm(UserPasswordUpdateType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $form->get('newPassword')->getData();
            $encodedPassword = $passwordEncoder->encodePassword($user, $plainPassword); 
            $user->setPassword($encodedPassword);

            $this->getDoctrine()->getManager()->flush();

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

    /**
     * @Route("/account/user_name_update", name ="user_name_update")
     */
    public function userNameUpdate(Request $request)
    {
        // $user->getToken(); je me demande si je ne dois pas plutot recupe le token... 
        /** @var AppUser $user */
        $user = $this->getUser();
        $form = $this->createForm(UserNameUpdateType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $newName = $form->get('newName')->getData();
            $user->setName($newName);

            $this->getDoctrine()->getManager()->flush();
            
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
                "errors" => "Une erreur s'est produite lors du changement de nom"
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
