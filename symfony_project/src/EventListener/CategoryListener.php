<?php

namespace App\EventListener;

use App\Entity\Category;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;

class CategoryListener
{
    private iterable $notifiers;

    public function __construct(iterable $notifiers)
    {
        $this->notifiers = $notifiers;
    }

    public function postPersist(PostPersistEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof Category) {
            return;
        }

        $message = sprintf('Category "%s" was added.', $entity->getCode());

        foreach ($this->notifiers as $notifier) {
            $notifier->notify($message);
        }
    }

    public function postUpdate(PostUpdateEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof Category) {
            return;
        }

        $message = sprintf('Category "%s" was updated.', $entity->getCode());

        foreach ($this->notifiers as $notifier) {
            $notifier->notify($message);
        }
    }
}
