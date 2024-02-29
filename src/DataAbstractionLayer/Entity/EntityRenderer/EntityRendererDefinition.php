<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityRenderer;

use Ovv\Entity\DataAbstractionLayer\Entity\EntityRenderer\Aggregate\EntityRendererEntityType\EntityRendererEntityTypeDefinition;
use Ovv\Entity\DataAbstractionLayer\Entity\EntityRenderer\Aggregate\EntityRendererEntity\EntityRendererEntityDefinition;
use Ovv\Entity\DataAbstractionLayer\Entity\EntityTemplate\EntityTemplateDefinition;
use Ovv\Entity\DataAbstractionLayer\Entity\EntityType\EntityTypeDefinition;
use Ovv\Entity\DataAbstractionLayer\Entity\Entity\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition as ParentClass;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CustomFields;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\CascadeDelete;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\SearchRanking;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\LongTextField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;

class EntityRendererDefinition extends ParentClass
{
    final public const ENTITY_NAME = 'ovv_entity_renderer';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return EntityRendererCollection::class;
    }

    public function getEntityClass(): string
    {
        return EntityRendererEntity::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            new IntField('auto_increment', 'autoIncrement'),
            (new FkField('template_id', 'templateId', EntityTemplateDefinition::class))->addFlags(new Required()),
            new BoolField('active', 'active'),
            (new StringField('name', 'name'))->addFlags(new Required(), new SearchRanking(SearchRanking::HIGH_SEARCH_RANKING)),
            (new StringField('slug', 'slug'))->addFlags(new SearchRanking(SearchRanking::MIDDLE_SEARCH_RANKING)),
            (new LongTextField('description', 'description'))->addFlags(new SearchRanking(SearchRanking::MIDDLE_SEARCH_RANKING)),
            new ManyToOneAssociationField('template', 'template_id', EntityTemplateDefinition::class),
            (new ManyToManyAssociationField('types', EntityTypeDefinition::class, EntityRendererEntityTypeDefinition::class, 'renderer_id', 'type_id'))->addFlags(new CascadeDelete(), new SearchRanking(SearchRanking::ASSOCIATION_SEARCH_RANKING)),
            (new ManyToManyAssociationField('entities', EntityDefinition::class, EntityRendererEntityDefinition::class, 'renderer_id', 'entity_id'))->addFlags(new CascadeDelete(), new SearchRanking(SearchRanking::ASSOCIATION_SEARCH_RANKING)),
            new CustomFields(),
        ]);
    }
}
