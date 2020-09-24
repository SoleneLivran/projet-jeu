<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        dump($error);

        return $this->render('@EasyAdmin/page/login.html.twig', [
            // parameters usually defined in Symfony login forms
            'error' => $error,
            'last_username' => $lastUsername,

            // the label displayed for the username form field (the |trans filter is applied to it)
            'username_label' => 'Admin username',

            // the label displayed for the password form field (the |trans filter is applied to it)
            'password_label' => 'Admin password',

            // the label displayed for the Sign In form button (the |trans filter is applied to it)
            'sign_in_label' => '➤ Jump into the Admin\'s World',

            'page_title' => '~ GWITH ~',

            // the URL users are redirected to after the login (default: '/admin')
            'target_path' => $this->generateUrl('api_admin_dashboard'),

        ]);
       
    
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
     * @Route("/logout", name="logout")
     * 
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
