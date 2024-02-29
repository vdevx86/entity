<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\Entity\Aggregate\EntityCustomFieldSet;

use Ovv\Entity\DataAbstractionLayer\Entity\Entity\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\MappingEntityDefinition;
use Shopware\Core\System\CustomField\Aggregate\CustomFieldSet\CustomFieldSetDefinition;

class EntityCustomFieldSetDefinition extends MappingEntityDefinition
{
    final public const ENTITY_NAME = 'ovv_entity_custom_field_set';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new FkField('entity_id', 'entityId', EntityDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            (new FkField('custom_field_set_id', 'customFieldSetId', CustomFieldSetDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            new ManyToOneAssociationField('entity', 'entity_id', EntityDefinition::class),
            new ManyToOneAssociationField('customFieldSet', 'custom_field_set_id', CustomFieldSetDefinition::class),
        ]);
    }
}
