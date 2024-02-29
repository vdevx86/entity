<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Migration;

use Doctrine\DBAL\Connection;

class Migration1705384983EntityRendererTable extends Migration\AbstractMigrationStep
{
    public function update(Connection $connection): void
    {
        $sql = <<< 'SQL'
CREATE TABLE IF NOT EXISTS `ovv_entity_renderer` (
    `id` BINARY(16) NOT NULL,
    `auto_increment` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `template_id` BINARY(16),
    `active` TINYINT(1) UNSIGNED,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255),
    `description` TEXT,
    `custom_fields` JSON,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3),
    PRIMARY KEY (`id`),
    UNIQUE `uniq.ovv_entity_renderer.auto_increment` (`auto_increment`),
    CONSTRAINT `fk.ovv_entity_renderer.template_id` FOREIGN KEY (`template_id`)
        REFERENCES `ovv_entity_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `json.ovv_entity_renderer.custom_fields` CHECK (JSON_VALID(`custom_fields`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL;

        $connection->executeStatement($sql);
    }
}
