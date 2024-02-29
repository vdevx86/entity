<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Installer;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\CountAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

abstract class AbstractInstaller implements InstallerInterface
{
    protected function entityExists(EntityRepository $repository, string $entityId, Context $context): bool
    {
        $criteria = (new Criteria([$entityId]))
            ->addAggregation(new CountAggregation('count', 'id'))
            ->setLimit(1);

        $count = $repository->aggregate($criteria, $context)
            ->get('count')
            ->getCount();

        return $count > 0;
    }
}
