<?php

namespace App\Controller;

use App\Repository\AppUserRepository;
use App\Entity\AppUser;
use App\Form\AvatarType;
use App\Form\RegistrationFormType;
use App\Form\UserAccountUpdateType;
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
                "errors" => $form->getErrors(true),
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

        $submittedData = json_decode($request->getContent(), true);
        // false = clear missing fields
        $form->submit($submittedData, false);

        if($form->isSubmitted() && $form->isValid()) {

            $newName = $form->get('newName')->getData();
            if (!empty($newName)) {
                $user->setName($newName);
            }

            $newMail = $form->get('newMail')->getData();
            if (!empty($newMail)) {
                $user->setMail($newMail);
            }

            $plainPassword = $form->get('newPassword')->getData();
            if (!empty($plainPassword)) {
                $encodedPassword = $passwordEncoder->encodePassword($user, $plainPassword);
                $user->setPassword($encodedPassword);
            }

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
                "errors" => $form->getErrors(true),
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @Route("/account/{id}/avatar", name="avatar_update", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function avatar(Request $request, UserInterface $user)
    {
        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can\'t update another person\'s account!');
        }

        $submittedData = json_decode($request->getContent(), true);

        /** @var AppUser $user */
        $user = $this->getUser();
        $form = $this->createForm(AvatarType::class, $user);
        // false = clear missing fields
        $form->submit($submittedData, false);

        if ($form->isSubmitted() && $form->isValid()) {
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
                "errors" => $form->getErrors(true),
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
