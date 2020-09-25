<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(request $request, MailerInterface $mailer)
    {
        //$contactData = json_decode($request->getContent(), true);
        
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        //$form->submit($contactData, true);
        
        if ($form->isSubmitted() && $form->isValid()) {

            //$contactFormData = $form->getData();

            $email = (new Email())
                ->from('contact@gwith.fr')
                ->to(new Address('gwith.project@gmail.com', 'GWITH'))
                ->text($form->get('message'))
            ;

            $mailer->send($email);

            return $this->json(
                [
                    "success" => true
                ],
                Response::HTTP_OK
            );
        }
        
        return $this->render(
            'contact/contact.html.twig',
            [
                "email_form" => $form->createView()
            ]
        );
        /* return $this->json(
            [
                "success" => false,
                "errors" => $form->getErrors(),
            ],
            Response::HTTP_BAD_REQUEST
        ); */
    }
}
