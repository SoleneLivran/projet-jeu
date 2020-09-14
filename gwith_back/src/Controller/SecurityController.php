<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        dump($error);

        return $error;
    }

    /**
    * @Route("/api/login_check", name="login_check")
    */
    public function apiLoginCheck()
    {
        // ce controller ne sert a rien il permet juste de créer une nouvelle route
        // cette route va etre interceptée par le systeme de securité de LexikJWT
        throw new \LogicException('This method can be blank - it will be intercepted by the Lexik JWT key on your firewall.');
    }

    /**
     * @Route("/logout", name="app_logout")
     * 
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
