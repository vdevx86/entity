<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\Entity\Aggregate\EntityTranslation;

use Ovv\Entity\DataAbstractionLayer\Entity\Entity\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition as ParentClass;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CustomFields;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\AllowHtml;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\LongTextField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;

class EntityTranslationDefinition extends ParentClass
{
    final public const ENTITY_NAME = 'ovv_entity_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return EntityTranslationCollection::class;
    }

    public function getEntityClass(): string
    {
        return EntityTranslationEntity::class;
    }

    public function getParentDefinitionClass(): string
    {
        return EntityDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('name', 'name'))->addFlags(new Required()),
            (new LongTextField('description', 'description'))->addFlags(new AllowHtml(false)),
            new CustomFields(),
        ]);
    }
}
