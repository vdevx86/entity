<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\Entity;

use Ovv\Entity\DataAbstractionLayer\EntityCollection as ParentClass;

class EntityCollection extends ParentClass
{
    protected function getExpectedClass(): string
    {
        return EntityEntity::class;
    }
}
