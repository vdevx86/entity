<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityTemplate;

use Ovv\Entity\DataAbstractionLayer\EntityCollection;

class EntityTemplateCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return EntityTemplateEntity::class;
    }
}
