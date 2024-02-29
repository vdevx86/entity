<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityType;

use Ovv\Entity\DataAbstractionLayer\Entity\EntityRenderer\EntityRendererCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCustomFieldsTrait;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class EntityTypeEntity extends Entity
{
    use EntityIdTrait;
    use EntityCustomFieldsTrait;

    protected int $autoIncrement;
    protected ?bool $active = null;
    protected ?string $name = null;
    protected ?string $slug = null;
    protected ?EntityRendererCollection $renderers = null;

    public function getAutoIncrement(): int
    {
        return $this->autoIncrement;
    }

    public function setAutoIncrement(int $autoIncrement): void
    {
        $this->autoIncrement = $autoIncrement;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): void
    {
        $this->active = $active;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getRenderers(): ?EntityRendererCollection
    {
        return $this->renderers;
    }

    public function setRenderers(?EntityRendererCollection $renderers): void
    {
        $this->renderers = $renderers;
    }
}
