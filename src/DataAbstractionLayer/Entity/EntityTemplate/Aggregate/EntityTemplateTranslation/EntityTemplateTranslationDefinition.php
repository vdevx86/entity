<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityTemplate\Aggregate\EntityTemplateTranslation;

use Ovv\Entity\DataAbstractionLayer\Entity\EntityTemplate\EntityTemplateDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CustomFields;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\AllowHtml;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\LongTextField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;

class EntityTemplateTranslationDefinition extends EntityTranslationDefinition
{
    final public const ENTITY_NAME = 'ovv_entity_template_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return EntityTemplateTranslationCollection::class;
    }

    public function getEntityClass(): string
    {
        return EntityTemplateTranslationEntity::class;
    }

    public function getParentDefinitionClass(): string
    {
        return EntityTemplateDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('name', 'name'))->addFlags(new Required()),
            (new LongTextField('template', 'template'))->addFlags(new Required(), new AllowHtml(false)),
            new CustomFields(),
        ]);
    }
}
