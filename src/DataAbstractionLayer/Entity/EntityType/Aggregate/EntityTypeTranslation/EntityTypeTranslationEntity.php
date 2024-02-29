<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityType\Aggregate\EntityTypeTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\TranslationEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCustomFieldsTrait;

class EntityTypeTranslationEntity extends TranslationEntity
{
    use EntityCustomFieldsTrait;

    protected ?string $name = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
