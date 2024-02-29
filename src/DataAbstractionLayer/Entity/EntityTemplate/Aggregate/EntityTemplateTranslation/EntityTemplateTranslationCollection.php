<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityTemplate\Aggregate\EntityTemplateTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

class EntityTemplateTranslationCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return EntityTemplateTranslationEntity::class;
    }
}
