<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Migration;

use Doctrine\DBAL\Connection;

class Migration1703288948EntityTable extends Migration\AbstractMigrationStep
{
    public function update(Connection $connection): void
    {
        $sql = <<< 'SQL'
CREATE TABLE IF NOT EXISTS `ovv_entity` (
    `id` BINARY(16) NOT NULL,
    `auto_increment` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `sales_channel_id` BINARY(16),
    `type_id` BINARY(16),
    `media_id` BINARY(16),
    `active` TINYINT(1) UNSIGNED,
    `slug` VARCHAR(255),
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3),
    PRIMARY KEY (`id`),
    UNIQUE `uniq.ovv_entity.auto_increment` (`auto_increment`),
    CONSTRAINT `fk.ovv_entity.sales_channel_id` FOREIGN KEY (`sales_channel_id`)
        REFERENCES `sales_channel` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `fk.ovv_entity.type_id` FOREIGN KEY (`type_id`)
        REFERENCES `ovv_entity_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL;

        $connection->executeStatement($sql);
    }
}
