<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityRenderer\Aggregate\EntityRendererEntity;

use Ovv\Entity\DataAbstractionLayer\Entity\EntityRenderer\EntityRendererDefinition;
use Ovv\Entity\DataAbstractionLayer\Entity\Entity\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\MappingEntityDefinition;

class EntityRendererEntityDefinition extends MappingEntityDefinition
{
    final public const ENTITY_NAME = 'ovv_entity_renderer_entity';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new FkField('renderer_id', 'rendererId', EntityRendererDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            (new FkField('entity_id', 'entityId', EntityDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            new ManyToOneAssociationField('renderer', 'renderer_id', EntityRendererDefinition::class),
            new ManyToOneAssociationField('entity', 'entity_id', EntityDefinition::class),
        ]);
    }
}
