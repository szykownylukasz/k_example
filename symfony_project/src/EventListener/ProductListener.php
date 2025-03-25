<?php

namespace App\EventListener;

use App\Entity\Product;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;

class ProductListener
{
    private iterable $notifiers;

    public function __construct(iterable $notifiers)
    {
        $this->notifiers = $notifiers;
    }

    public function postPersist(PostPersistEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof Product) {
            return;
        }

        $message = sprintf('Product "%s" was added.', $entity->getName());

        foreach ($this->notifiers as $notifier) {
            $notifier->notify($message);
        }
    }

    public function postUpdate(PostUpdateEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof Product) {
            return;
        }

        $message = sprintf('Product "%s" was updated.', $entity->getName());

        foreach ($this->notifiers as $notifier) {
            $notifier->notify($message);
        }
    }
}
