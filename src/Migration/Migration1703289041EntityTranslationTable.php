<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Migration;

use Doctrine\DBAL\Connection;

class Migration1703289041EntityTranslationTable extends Migration\AbstractMigrationStep
{
    public function update(Connection $connection): void
    {
        $sql = <<< 'SQL'
CREATE TABLE IF NOT EXISTS `ovv_entity_translation` (
    `ovv_entity_id` BINARY(16) NOT NULL,
    `language_id` BINARY(16) NOT NULL,
    `name` VARCHAR(255),
    `description` TEXT,
    `custom_fields` JSON,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3),
    PRIMARY KEY (`ovv_entity_id`, `language_id`),
    CONSTRAINT `fk.ovv_entity_translation.ovv_entity_id` FOREIGN KEY (`ovv_entity_id`)
        REFERENCES `ovv_entity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk.ovv_entity_translation.language_id` FOREIGN KEY (`language_id`)
        REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `json.ovv_entity_translation.custom_fields` CHECK (JSON_VALID(`custom_fields`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL;

        $connection->executeStatement($sql);
    }
}
