<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityType;

use Ovv\Entity\DataAbstractionLayer\Entity\EntityRenderer\Aggregate\EntityRendererEntityType\EntityRendererEntityTypeDefinition;
use Ovv\Entity\DataAbstractionLayer\Entity\EntityRenderer\EntityRendererDefinition;
use Ovv\Entity\DataAbstractionLayer\Entity\EntityType\Aggregate\EntityTypeTranslation\EntityTypeTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\CascadeDelete;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\SearchRanking;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;

class EntityTypeDefinition extends EntityDefinition
{
    final public const ENTITY_NAME = 'ovv_entity_type';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return EntityTypeCollection::class;
    }

    public function getEntityClass(): string
    {
        return EntityTypeEntity::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            new IntField('auto_increment', 'autoIncrement'),
            new BoolField('active', 'active'),
            new StringField('slug', 'slug'),
            (new TranslatedField('name'))->addFlags(new SearchRanking(SearchRanking::HIGH_SEARCH_RANKING)),
            new TranslatedField('customFields'),
            (new TranslationsAssociationField(EntityTypeTranslationDefinition::class, 'ovv_entity_type_id'))->addFlags(new Required()),
            (new ManyToManyAssociationField('renderers', EntityRendererDefinition::class, EntityRendererEntityTypeDefinition::class, 'type_id', 'renderer_id'))->addFlags(new CascadeDelete()),
        ]);
    }
}
