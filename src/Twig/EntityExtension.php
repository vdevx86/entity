<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Twig;

use Ovv\Entity\Service\TwigExtensionServiceInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EntityExtension extends AbstractExtension
{
    public function __construct(
        private readonly TwigExtensionServiceInterface $twigExtensionService,
    ) { }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('entityById', [$this->twigExtensionService, 'entityById']),
            new TwigFunction('entityBySlug', [$this->twigExtensionService, 'entityBySlug']),
            new TwigFunction('entityByTypeId', [$this->twigExtensionService, 'entityByTypeId']),
            new TwigFunction('entityTypeById', [$this->twigExtensionService, 'entityTypeById']),
            new TwigFunction('entityTypeBySlug', [$this->twigExtensionService, 'entityTypeBySlug']),
            new TwigFunction('entityTemplateById', [$this->twigExtensionService, 'entityTemplateById']),
            new TwigFunction('entityTemplateBySlug', [$this->twigExtensionService, 'entityTemplateBySlug']),
            new TwigFunction('entityRenderById', [$this->twigExtensionService, 'entityRenderById']),
            new TwigFunction('entityRenderBySlug', [$this->twigExtensionService, 'entityRenderBySlug']),
        ];
    }
}
