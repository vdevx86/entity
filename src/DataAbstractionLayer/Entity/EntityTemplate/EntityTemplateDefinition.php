<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityTemplate;

use Ovv\Entity\DataAbstractionLayer\Entity\EntityTemplate\Aggregate\EntityTemplateTranslation\EntityTemplateTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\SearchRanking;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;

class EntityTemplateDefinition extends EntityDefinition
{
    final public const ENTITY_NAME = 'ovv_entity_template';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return EntityTemplateCollection::class;
    }

    public function getEntityClass(): string
    {
        return EntityTemplateEntity::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            new IntField('auto_increment', 'autoIncrement'),
            new StringField('slug', 'slug'),
            (new TranslatedField('name'))->addFlags(new SearchRanking(SearchRanking::HIGH_SEARCH_RANKING)),
            (new TranslatedField('template'))->addFlags(new SearchRanking(SearchRanking::HIGH_SEARCH_RANKING)),
            new TranslatedField('customFields'),
            (new TranslationsAssociationField(EntityTemplateTranslationDefinition::class, 'ovv_entity_template_id'))->addFlags(new Required()),
        ]);
    }
}
