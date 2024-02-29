<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\Entity;

use Ovv\Entity\DataAbstractionLayer\Entity\EntityRenderer\Aggregate\EntityRendererEntity\EntityRendererEntityDefinition;
use Ovv\Entity\DataAbstractionLayer\Entity\EntityRenderer\EntityRendererDefinition;
use Ovv\Entity\DataAbstractionLayer\Entity\EntityType\EntityTypeDefinition;
use Ovv\Entity\DataAbstractionLayer\Entity\Entity\Aggregate\EntityCustomFieldSet\EntityCustomFieldSetDefinition;
use Ovv\Entity\DataAbstractionLayer\Entity\Entity\Aggregate\EntityMedia\EntityMediaDefinition;
use Ovv\Entity\DataAbstractionLayer\Entity\Entity\Aggregate\EntityTranslation\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition as ParentClass;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\CascadeDelete;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\NoConstraint;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\SearchRanking;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\System\CustomField\Aggregate\CustomFieldSet\CustomFieldSetDefinition;
use Shopware\Core\System\SalesChannel\SalesChannelDefinition;

class EntityDefinition extends ParentClass
{
    final public const ENTITY_NAME = 'ovv_entity';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return EntityCollection::class;
    }

    public function getEntityClass(): string
    {
        return EntityEntity::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            new IntField('auto_increment', 'autoIncrement'),
            new FkField('sales_channel_id', 'salesChannelId', SalesChannelDefinition::class),
            new FkField('type_id', 'typeId', EntityTypeDefinition::class),
            (new FkField('media_id', 'coverId', EntityMediaDefinition::class))->addFlags(new NoConstraint()),
            new BoolField('active', 'active'),
            new StringField('slug', 'slug'),
            (new TranslatedField('name'))->addFlags(new SearchRanking(SearchRanking::HIGH_SEARCH_RANKING)),
            (new TranslatedField('description'))->addFlags(new SearchRanking(SearchRanking::MIDDLE_SEARCH_RANKING)),
            new TranslatedField('customFields'),
            new ManyToOneAssociationField('salesChannel', 'sales_channel_id', SalesChannelDefinition::class),
            new ManyToOneAssociationField('type', 'type_id', EntityTypeDefinition::class),
            new ManyToOneAssociationField('cover', 'media_id', EntityMediaDefinition::class),
            (new OneToManyAssociationField('media', EntityMediaDefinition::class, 'entity_id'))->addFlags(new CascadeDelete()),
            (new TranslationsAssociationField(EntityTranslationDefinition::class, 'ovv_entity_id'))->addFlags(new Required()),
            (new ManyToManyAssociationField('customFieldSets', CustomFieldSetDefinition::class, EntityCustomFieldSetDefinition::class, 'entity_id', 'custom_field_set_id'))->addFlags(new CascadeDelete()),
            (new ManyToManyAssociationField('renderers', EntityRendererDefinition::class, EntityRendererEntityDefinition::class, 'entity_id', 'renderer_id'))->addFlags(new CascadeDelete()),
        ]);
    }
}
