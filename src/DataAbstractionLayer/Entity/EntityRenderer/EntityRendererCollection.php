<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityRenderer;

use Ovv\Entity\DataAbstractionLayer\EntityCollection;

class EntityRendererCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return EntityRendererEntity::class;
    }
}
