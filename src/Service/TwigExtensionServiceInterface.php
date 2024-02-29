<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Service;

use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\Struct\Collection;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

interface TwigExtensionServiceInterface
{
    public function setSalesChannelContext(?SalesChannelContext $salesChannelContext): TwigExtensionServiceInterface;

    public function getSalesChannelContext(): ?SalesChannelContext;

    public function entityById(array $ids): ?EntitySearchResult;

    public function entityBySlug(array $slugs): ?EntitySearchResult;

    public function entityByTypeId(array $ids): ?EntitySearchResult;

    public function entityTypeById(array $ids): ?EntitySearchResult;

    public function entityTypeBySlug(array $slugs): ?EntitySearchResult;

    public function entityTemplateById(array $ids): ?EntitySearchResult;

    public function entityTemplateBySlug(array $slugs): ?EntitySearchResult;

    public function entityRenderById(int $id, ?Collection $entities): ?string;

    public function entityRenderBySlug(string $slug, ?Collection $entities): ?string;
}
