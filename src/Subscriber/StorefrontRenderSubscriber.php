<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Subscriber;

use Ovv\Entity\Service\ContextStruct;
use Shopware\Storefront\Event\StorefrontRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StorefrontRenderSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly ContextStruct $contextStruct,
    ) { }

    public static function getSubscribedEvents(): array
    {
        return [
            StorefrontRenderEvent::class => 'execute',
        ];
    }

    public function execute(StorefrontRenderEvent $event): void
    {
        $this->contextStruct->setSalesChannelContext($event->getSalesChannelContext());
    }
}
