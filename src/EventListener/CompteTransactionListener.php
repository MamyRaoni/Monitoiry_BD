<?php 
namespace App\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use App\Entity\Compte;

class CompteTransactionListener implements EventSubscriber
{
    private HubInterface $hub;
    private bool $modificationDetected = false;

    public function __construct(HubInterface $hub)
    {
        $this->hub = $hub;
    }

    public function getSubscribedEvents(): array
    {
        return [
            'postFlush',
            'postUpdate',
            'postPersist',
            'postRemove',
        ];
    }

    public function postFlush(PostFlushEventArgs $args): void
    {
        if ($this->modificationDetected) {
            $update = new Update(
                'http://example.com/notifications',
                json_encode(['message' => "✅ Modification confirmée sur un compte."])
            );

            $this->hub->publish($update);
            $this->modificationDetected = false; // Réinitialiser l'état
        }
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        if ($args->getObject() instanceof Compte) {
            $this->modificationDetected = true;
        }
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        if ($args->getObject() instanceof Compte) {
            $this->modificationDetected = true;
        }
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        if ($args->getObject() instanceof Compte) {
            $this->modificationDetected = true;
        }
    }
}
