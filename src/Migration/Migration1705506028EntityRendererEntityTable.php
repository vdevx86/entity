<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Migration;

use Doctrine\DBAL\Connection;

class Migration1705506028EntityRendererEntityTable extends Migration\AbstractMigrationStep
{
    public function update(Connection $connection): void
    {
        $sql = <<< 'SQL'
CREATE TABLE IF NOT EXISTS `ovv_entity_renderer_entity` (
    `renderer_id` BINARY(16) NOT NULL,
    `entity_id` BINARY(16) NOT NULL,
    PRIMARY KEY (`renderer_id`, `entity_id`),
    CONSTRAINT `fk.ovv_entity_renderer_entity.renderer_id` FOREIGN KEY (`renderer_id`)
        REFERENCES `ovv_entity_renderer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk.ovv_entity_renderer_entity.entity_id` FOREIGN KEY (`entity_id`)
        REFERENCES `ovv_entity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL;

        $connection->executeStatement($sql);
    }
}
