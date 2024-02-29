<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Subscriber;

use Ovv\Entity\Service\ContentProcessorInterface;
use Ovv\Entity\Service\ContextStruct;
use Shopware\Storefront\Framework\Routing\StorefrontResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelResponseSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly ContentProcessorInterface $contentProcessor,
        private readonly ContextStruct $contextStruct,
    ) { }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'execute',
        ];
    }

    public function execute(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        if (!$response instanceof StorefrontResponse) {
            return;
        }

        $context = $this->contextStruct->getSalesChannelContext();
        if (!$context) {
            return;
        }

        $twig = $this->contextStruct->getTwig();
        if (!$twig) {
            return;
        }

        $content = $response->getContent();

        $this->contentProcessor->process($content, $twig, $context);

        $response->setContent($content);
    }
}
