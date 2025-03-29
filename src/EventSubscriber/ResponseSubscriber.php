<?php

namespace App\EventSubscriber;

use App\Service\NotificationService;
use LoginResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ResponseSubscriber implements EventSubscriberInterface
{
    public function onSecurityInteractiveLogin(LoginResponseEvent $event, NotificationService $notificationService): void
    {
        // ...
        //dump($event->getUserMail());
        //$notificationService->sendNotification("user ".$event->getUserMail()." est bien connecte");
        
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginResponseEvent::class => 'onSecurityInteractiveLogin',
            
        ];
    }
}
