<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Migration\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

abstract class AbstractMigrationStep extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return (int) \substr(\basename(\strtr(static::class, '\\', '/')), 9);
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
