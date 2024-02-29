<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\Entity\Aggregate\EntityTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

class EntityTranslationCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return EntityTranslationEntity::class;
    }
}
