<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Subscriber;

use Ovv\Entity\Service\ContextStruct;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment as TwigEnvironment;

class KernelControllerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly ContextStruct $contextStruct,
    ) { }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'execute',
        ];
    }

    public function execute(ControllerEvent $event): void
    {
        try {
            $this->readTwigEnvironment($event);
        } catch (\ReflectionException) {
            return;
        }
    }

    private function readTwigEnvironment(ControllerEvent $event): void
    {
        $controller = (new \ReflectionFunction(\Closure::fromCallable($event->getController())))
            ->getClosureThis();

        if (!$controller instanceof StorefrontController) {
            return;
        }

        $property = (new \ReflectionClass($controller))
            ->getParentClass()
            ->getProperty('twig');

        $property->setAccessible(true);

        $twig = $property->getValue($controller);
        if (!$twig instanceof TwigEnvironment) {
            return;
        }

        $this->contextStruct->setTwig($twig);
    }
}
