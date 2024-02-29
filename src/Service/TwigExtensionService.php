<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Service;

use Ovv\Entity\Service\ContextStruct;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\OrFilter;
use Shopware\Core\Framework\Struct\Collection;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

class TwigExtensionService implements TwigExtensionServiceInterface
{
    private ?SalesChannelContext $salesChannelContext = null;

    public function __construct(
        private readonly EntityRepository $entityRepository,
        private readonly EntityRepository $entityTypeRepository,
        private readonly EntityRepository $entityTemplateRepository,
        private readonly EntityRepository $entityRendererRepository,
        private readonly ContextStruct $contextStruct,
    ) { }

    public function setSalesChannelContext(?SalesChannelContext $salesChannelContext): TwigExtensionServiceInterface
    {
        $this->salesChannelContext = $salesChannelContext;

        return $this;
    }

    public function getSalesChannelContext(): ?SalesChannelContext
    {
        return $this->salesChannelContext;
    }

    public function entityById(array $ids): ?EntitySearchResult
    {
        $context = $this->extractSalesChannelContext();
        if (!$context) {
            return null;
        }

        $criteria = $this->createEntityCriteria($context)
            ->addFilter(new EqualsAnyFilter('autoIncrement', $ids))
            ->setLimit(count($ids));

        $criteria->setTitle('ovv-entity-twig-function::entity-by-id');

        return $this->entityRepository->search($criteria, $context->getContext());
    }

    public function entityBySlug(array $slugs): ?EntitySearchResult
    {
        $context = $this->extractSalesChannelContext();
        if (!$context) {
            return null;
        }

        $criteria = $this->createEntityCriteria($context)
            ->addFilter(new EqualsAnyFilter('slug', $slugs));

        $criteria->setTitle('ovv-entity-twig-function::entity-by-slug');

        return $this->entityRepository->search($criteria, $context->getContext());
    }

    public function entityByTypeId(array $ids): ?EntitySearchResult
    {
        $context = $this->extractSalesChannelContext();
        if (!$context) {
            return null;
        }

        $criteria = $this->createEntityCriteria($context)
            ->addFilter(new EqualsAnyFilter('type.autoIncrement', $ids));

        $criteria->setTitle('ovv-entity-twig-function::entity-by-type-id');

        return $this->entityRepository->search($criteria, $context->getContext());
    }

    public function entityTypeById(array $ids): ?EntitySearchResult
    {
        $context = $this->extractSalesChannelContext();
        if (!$context) {
            return null;
        }

        $criteria = (new Criteria())
            ->addFilter(new EqualsFilter('active', true))
            ->addFilter(new EqualsAnyFilter('autoIncrement', $ids))
            ->setLimit(count($ids));

        $criteria->setTitle('ovv-entity-twig-function::entity-type-by-id');

        return $this->entityTypeRepository->search($criteria, $context->getContext());
    }

    public function entityTypeBySlug(array $slugs): ?EntitySearchResult
    {
        $context = $this->extractSalesChannelContext();
        if (!$context) {
            return null;
        }

        $criteria = (new Criteria())
            ->addFilter(new EqualsFilter('active', true))
            ->addFilter(new EqualsAnyFilter('slug', $slugs));

        $criteria->setTitle('ovv-entity-twig-function::entity-type-by-slug');

        return $this->entityTypeRepository->search($criteria, $context->getContext());
    }

    public function entityTemplateById(array $ids): ?EntitySearchResult
    {
        $context = $this->extractSalesChannelContext();
        if (!$context) {
            return null;
        }

        $criteria = (new Criteria())
            ->addFilter(new EqualsAnyFilter('autoIncrement', $ids))
            ->setLimit(count($ids));

        $criteria->setTitle('ovv-entity-twig-function::entity-template-by-id');

        return $this->entityTemplateRepository->search($criteria, $context->getContext());
    }

    public function entityTemplateBySlug(array $slugs): ?EntitySearchResult
    {
        $context = $this->extractSalesChannelContext();
        if (!$context) {
            return null;
        }

        $criteria = (new Criteria())
            ->addFilter(new EqualsAnyFilter('slug', $slugs));

        $criteria->setTitle('ovv-entity-twig-function::entity-template-by-slug');

        return $this->entityTemplateRepository->search($criteria, $context->getContext());
    }

    public function entityRenderById(int $id, ?Collection $entities): ?string
    {
        if (!$entities) {
            return null;
        }

        $context = $this->extractSalesChannelContext();
        if (!$context) {
            return null;
        }

        $criteria = (new Criteria())
            ->addAssociation('template')
            ->addFilter(new EqualsFilter('active', true))
            ->addFilter(new EqualsFilter('autoIncrement', $id))
            ->setLimit(1);

        $criteria->setTitle('ovv-entity-twig-function::entity-render-by-id');

        return $this->entityRenderBy($criteria, $entities, $context->getContext());
    }

    public function entityRenderBySlug(string $slug, ?Collection $entities): ?string
    {
        if (!$entities) {
            return null;
        }

        $context = $this->extractSalesChannelContext();
        if (!$context) {
            return null;
        }

        $criteria = (new Criteria())
            ->addAssociation('template')
            ->addFilter(new EqualsFilter('active', true))
            ->addFilter(new EqualsFilter('slug', $slug))
            ->setLimit(1);

        $criteria->setTitle('ovv-entity-twig-function::entity-render-by-slug');

        return $this->entityRenderBy($criteria, $entities, $context->getContext());
    }

    private function entityRenderBy(Criteria $criteria, Collection $entities, Context $context): ?string
    {
        $twig = $this->contextStruct->getTwig();
        if (!$twig) {
            return null;
        }

        $entityRenderers = $this->entityRendererRepository->search($criteria, $context);
        if ($entityRenderers->count() <= 0) {
            return null;
        }

        $entityRenderer = $entityRenderers->first();

        $template = $entityRenderer->getTemplate()->getTranslation('template');
        if (!$template) {
            return null;
        }

        return $twig->createTemplate($template)->render([
            'entities' => $entities,
        ]);
    }

    private function extractSalesChannelContext(): ?SalesChannelContext
    {
        return $this->contextStruct->getSalesChannelContext() ?? $this->salesChannelContext;
    }

    private function createEntityCriteria(SalesChannelContext $context): Criteria
    {
        $criteria = (new Criteria())
            ->addAssociation('type')
            ->addAssociation('cover')
            ->addAssociation('media.thumbnails')
            ->addFilter(new OrFilter([
                new EqualsFilter('salesChannelId', null),
                new EqualsFilter('salesChannelId', $context->getSalesChannelId()),
            ]))
            ->addFilter(new EqualsFilter('active', true))
            ->addFilter(new EqualsFilter('type.active', true));

        return $criteria;
    }
}
