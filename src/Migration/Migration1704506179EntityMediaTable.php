<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Migration;

use Doctrine\DBAL\Connection;

class Migration1704506179EntityMediaTable extends Migration\AbstractMigrationStep
{
    public function update(Connection $connection): void
    {
        $sql = <<< 'SQL'
CREATE TABLE IF NOT EXISTS `ovv_entity_media` (
    `id` BINARY(16) NOT NULL,
    `position` INT(11) NOT NULL DEFAULT 1,
    `entity_id` BINARY(16) NOT NULL,
    `media_id` BINARY(16) NOT NULL,
    `custom_fields` JSON,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3) NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk.ovv_entity_media.media_id` FOREIGN KEY (`media_id`)
        REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk.ovv_entity_media.entity_id` FOREIGN KEY (`entity_id`)
        REFERENCES `ovv_entity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `json.ovv_entity_media.custom_fields` CHECK (JSON_VALID(`custom_fields`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL;

        $connection->executeStatement($sql);
    }
}
