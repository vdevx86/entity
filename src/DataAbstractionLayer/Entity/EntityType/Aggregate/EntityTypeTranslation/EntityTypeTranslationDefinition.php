<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityType\Aggregate\EntityTypeTranslation;

use Ovv\Entity\DataAbstractionLayer\Entity\EntityType\EntityTypeDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CustomFields;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;

class EntityTypeTranslationDefinition extends EntityTranslationDefinition
{
    final public const ENTITY_NAME = 'ovv_entity_type_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return EntityTypeTranslationCollection::class;
    }

    public function getEntityClass(): string
    {
        return EntityTypeTranslationEntity::class;
    }

    public function getParentDefinitionClass(): string
    {
        return EntityTypeDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('name', 'name'))->addFlags(new Required()),
            new CustomFields(),
        ]);
    }
}
