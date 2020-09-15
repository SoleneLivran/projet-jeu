<?php

namespace App\Controller;

use App\Security\EmailVerifier;
use App\Entity\AppUser;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
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
    public function createAccount(request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new AppUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('Password')->getData();
            $encodedPassword = $passwordEncoder->encodePassword($user, $plainPassword);
            $user->setPassword($encodedPassword);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_login');
         
        }

        return $this->render('registration/register.html.twig',
        [
            "form" => $form->createView()
        ]
    );
    }
}
