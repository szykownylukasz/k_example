<?php

namespace App\Tests\EventListener;

use App\Entity\Category;
use App\EventListener\CategoryListener;
use App\Notifier\NotifierInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use PHPUnit\Framework\TestCase;

class CategoryListenerTest extends TestCase
{
    private Category $category;
    private NotifierInterface $notifier1;
    private NotifierInterface $notifier2;
    private CategoryListener $listener;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->category = new Category();
        $this->category->setCode('TEST123');

        $this->notifier1 = $this->createMock(NotifierInterface::class);
        $this->notifier2 = $this->createMock(NotifierInterface::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        $this->listener = new CategoryListener([$this->notifier1, $this->notifier2]);
    }

    public function testPostPersistNotifiesAllNotifiers(): void
    {
        $expectedMessage = 'Category "TEST123" was added.';

        $this->notifier1->expects($this->once())
            ->method('notify')
            ->with($expectedMessage);

        $this->notifier2->expects($this->once())
            ->method('notify')
            ->with($expectedMessage);

        $eventArgs = new PostPersistEventArgs($this->category, $this->entityManager);
        $this->listener->postPersist($eventArgs);
    }

    public function testPostUpdateNotifiesAllNotifiers(): void
    {
        $expectedMessage = 'Category "TEST123" was updated.';

        $this->notifier1->expects($this->once())
            ->method('notify')
            ->with($expectedMessage);

        $this->notifier2->expects($this->once())
            ->method('notify')
            ->with($expectedMessage);

        $eventArgs = new PostUpdateEventArgs($this->category, $this->entityManager);
        $this->listener->postUpdate($eventArgs);
    }
}
