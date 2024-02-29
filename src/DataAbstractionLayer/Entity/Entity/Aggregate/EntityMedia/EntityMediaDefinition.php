<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\Entity\Aggregate\EntityMedia;

use Ovv\Entity\DataAbstractionLayer\Entity\Entity\EntityDefinition as ParentDefinition;
use Shopware\Core\Content\Media\MediaDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CustomFields;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;

class EntityMediaDefinition extends EntityDefinition
{
    final public const ENTITY_NAME = 'ovv_entity_media';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return EntityMediaCollection::class;
    }

    public function getEntityClass(): string
    {
        return EntityMediaEntity::class;
    }

    protected function getParentDefinitionClass(): ?string
    {
        return ParentDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            (new FkField('entity_id', 'entityId', ParentDefinition::class))->addFlags(new Required()),
            (new FkField('media_id', 'mediaId', MediaDefinition::class))->addFlags(new Required()),
            new IntField('position', 'position'),
            new ManyToOneAssociationField('entity', 'entity_id', ParentDefinition::class),
            new ManyToOneAssociationField('media', 'media_id', MediaDefinition::class, 'id', true),
            new CustomFields(),
        ]);
    }
}
