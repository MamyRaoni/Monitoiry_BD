<?php

namespace App\EventSubscriber;

use LoginResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ResponseSubscriber implements EventSubscriberInterface
{
    public function onSecurityInteractiveLogin(LoginResponseEvent $event): void
    {
        // ...
        dump($event->getUserMail());
        
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginResponseEvent::class => 'onSecurityInteractiveLogin',
        ];
    }
}
