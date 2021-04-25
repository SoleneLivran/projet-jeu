<?php

namespace App\EventListener;

use App\Entity\AppUser;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Security\Core\Security;

class JWTCreatedListener
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
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $user = $this->security->getUser();

        if ($user instanceof AppUser) {
            $payload['id'] = $user->getId();
        }

        $event->setData($payload);
    }
}