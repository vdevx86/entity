<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Migration;

use Doctrine\DBAL\Connection;

class Migration1705385558EntityRendererEntityTypeTable extends Migration\AbstractMigrationStep
{
    public function update(Connection $connection): void
    {
        $sql = <<< 'SQL'
CREATE TABLE IF NOT EXISTS `ovv_entity_renderer_entity_type` (
    `renderer_id` BINARY(16) NOT NULL,
    `type_id` BINARY(16) NOT NULL,
    PRIMARY KEY (`renderer_id`, `type_id`),
    CONSTRAINT `fk.ovv_entity_renderer_entity_type.renderer_id` FOREIGN KEY (`renderer_id`)
        REFERENCES `ovv_entity_renderer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk.ovv_entity_renderer_entity_type.type_id` FOREIGN KEY (`type_id`)
        REFERENCES `ovv_entity_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL;

        $connection->executeStatement($sql);
    }
}
