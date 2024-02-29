<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Migration;

use Doctrine\DBAL\Connection;

class Migration1703289045EntityCustomFieldSetsTable extends Migration\AbstractMigrationStep
{
    public function update(Connection $connection): void
    {
        $sql = <<< 'SQL'
CREATE TABLE IF NOT EXISTS `ovv_entity_custom_field_set` (
    `custom_field_set_id` BINARY(16) NOT NULL,
    `entity_id` BINARY(16) NOT NULL,
    PRIMARY KEY (`custom_field_set_id`, `entity_id`),
    CONSTRAINT `fk.ovv_entity_custom_field_set.custom_field_set_id` FOREIGN KEY (`custom_field_set_id`)
        REFERENCES `custom_field_set` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk.ovv_entity_custom_field_set.entity_id` FOREIGN KEY (`entity_id`)
        REFERENCES `ovv_entity` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL;

        $connection->executeStatement($sql);
    }
}
