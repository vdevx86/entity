<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityType\Aggregate\EntityTypeTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

class EntityTypeTranslationCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return EntityTypeTranslationEntity::class;
    }
}
