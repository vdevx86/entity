<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection as ParentClass;

class EntityCollection extends ParentClass
{
    public function getEntityIds(): ?array
    {
        $ids = parent::getIds();

        return $ids ? \array_values($ids) : null;
    }
}
