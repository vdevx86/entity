<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Service;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\OrFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Twig\Environment as TwigEnvironment;

class ContentProcessor implements ContentProcessorInterface
{
    public function __construct(
        private readonly EntityRepository $entityRepository,
        private readonly EntityRepository $entityRendererRepository,
    ) { }

    public function process(string &$content, TwigEnvironment $twig, SalesChannelContext $context): void
    {
        $prefix = static::REGEXP_PLACEHOLDER_PREFIX;

        do {
            $this->doProcess($content, $twig, $context);
        } while (\strpos($content, $prefix) !== false);
    }

    private function doProcess(string &$content, TwigEnvironment $twig, SalesChannelContext $context): void
    {
        $regExp = '/' . static::REGEXP_PLACEHOLDER_PREFIX . '([1-9][0-9]?)/Si';
        $matches = [];

        if (!\preg_match_all($regExp, $content, $matches, \PREG_SET_ORDER)) {
            return;
        }

        $matches = \array_column($matches, 0, 1);
        \krsort($matches, \SORT_NUMERIC);
        $renderedMap = \array_map(fn() => null, $matches);

        $salesChannelId = $context->getSalesChannelId();
        $context = $context->getContext();

        $criteria = (new Criteria())
            ->addAssociation('template')
            ->addAssociation('entities')
            ->addAssociation('types')
            ->addFilter(new EqualsAnyFilter('autoIncrement', \array_keys($matches)))
            ->setLimit(count($matches));

        $criteria->setTitle('ovv-entity-content-processor::entity-renderer');

        foreach ($this->entityRendererRepository->search($criteria, $context) as $entityRenderer) {
            $template = $entityRenderer->getTemplate()->getTranslation('template');
            if (!$template) {
                continue;
            }

            $criteria = (new Criteria($entityRenderer->getEntities()->getEntityIds()))
                ->addFilter(new OrFilter([
                    new EqualsFilter('salesChannelId', null),
                    new EqualsFilter('salesChannelId', $salesChannelId),
                ]))
                ->addFilter(new EqualsFilter('active', true))
                ->addFilter(new EqualsFilter('type.active', true))
                ->addAssociation('type')
                ->addAssociation('cover')
                ->addAssociation('media.thumbnails');

            $byIds = $entityRenderer->getTypes()->getEntityIds();
            if ($byIds) {
                $criteria->addFilter(new EqualsAnyFilter('type.id', $byIds));
            }

            $criteria->setTitle('ovv-entity-content-processor::entity');

            $renderedMap[$entityRenderer->getAutoIncrement()] = $twig->createTemplate($template)->render([
                'entities' => $this->entityRepository->search($criteria, $context),
            ]);
        }

        $content = \str_replace($matches, $renderedMap, $content);
    }
}
