<?php 
namespace App\Service;

use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class NotificationService{
    private $hub;

    public function __construct(HubInterface $hub){
        $this->hub=$hub;
    }
    public function sendNotification(string$message){
        $update=new Update(
            'http;//example.com/notifiactions',
            json_encode(['message'=>$message])
        );
        $this->hub->publish($update);
    }
}