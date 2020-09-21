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
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/api")
 */
class UserAccountController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function createAccount(request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        $userData = json_decode($request->getContent(), true);
        $user = new AppUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->submit($userData, true);
        
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
     * @Route("/account/{id}", name="account_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(UserInterface $user)
    {
        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can\'t delete another person\'s account!');
        }

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
     * @Route("/account/{id}", name="account_update", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function userAccountUpdate(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserInterface $user)
    {

        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can\'t update another person\'s account!');
        }

        /** @var AppUser $user */
        $user = $this->getUser();
        $form = $this->createForm(UserAccountUpdateType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $newName = $form->get('newName')->getData();
            $user->setName($newName);

            $newMail = $form->get('newMail')->getData();
            $user->setMail($newMail);

            $avatar = $form->get('avatar')->getData();
            $user->setAvatar($avatar);

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
                "errors" => "Une erreur s'\est produite lors de la mise à jour"
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
