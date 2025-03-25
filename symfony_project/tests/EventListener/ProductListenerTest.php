<?php

namespace App\Tests\EventListener;

use App\Entity\Product;
use App\EventListener\ProductListener;
use App\Notifier\NotifierInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use PHPUnit\Framework\TestCase;

class ProductListenerTest extends TestCase
{
    private Product $product;
    private NotifierInterface $notifier1;
    private NotifierInterface $notifier2;
    private ProductListener $listener;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->product = new Product();
        $this->product->setName('Testowy produkt');

        $this->notifier1 = $this->createMock(NotifierInterface::class);
        $this->notifier2 = $this->createMock(NotifierInterface::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        $this->listener = new ProductListener([$this->notifier1, $this->notifier2]);
    }

    public function testPostPersistNotifiesAllNotifiers(): void
    {
        $expectedMessage = 'Product "Testowy produkt" was added.';

        $this->notifier1->expects($this->once())
            ->method('notify')
            ->with($expectedMessage);

        $this->notifier2->expects($this->once())
            ->method('notify')
            ->with($expectedMessage);

        $eventArgs = new PostPersistEventArgs($this->product, $this->entityManager);
        $this->listener->postPersist($eventArgs);
    }

    public function testPostUpdateNotifiesAllNotifiers(): void
    {
        $expectedMessage = 'Product "Testowy produkt" was updated.';

        $this->notifier1->expects($this->once())
            ->method('notify')
            ->with($expectedMessage);

        $this->notifier2->expects($this->once())
            ->method('notify')
            ->with($expectedMessage);

        $eventArgs = new PostUpdateEventArgs($this->product, $this->entityManager);
        $this->listener->postUpdate($eventArgs);
    }
}
