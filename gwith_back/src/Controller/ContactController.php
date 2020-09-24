<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
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
    public function contact(MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = (new Email())
            ->from($form->get('from'))
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

        return $this->json(
            [
                "success" => false,
                "errors" => "Une erreur s'\est produite lors de l'\envoie de votre Mail"
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
