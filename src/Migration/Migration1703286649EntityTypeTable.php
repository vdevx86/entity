<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Migration;

use Doctrine\DBAL\Connection;

class Migration1703286649EntityTypeTable extends Migration\AbstractMigrationStep
{
    public function update(Connection $connection): void
    {
        $sql = <<< 'SQL'
CREATE TABLE IF NOT EXISTS `ovv_entity_type` (
    `id` BINARY(16) NOT NULL,
    `auto_increment` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `active` TINYINT(1) UNSIGNED,
    `slug` VARCHAR(255),
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3),
    PRIMARY KEY (`id`),
    UNIQUE `uniq.ovv_entity_type.auto_increment` (`auto_increment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL;

        $connection->executeStatement($sql);
    }
}
