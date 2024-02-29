<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityRenderer;

use Ovv\Entity\DataAbstractionLayer\Entity\EntityTemplate\EntityTemplateEntity;
use Ovv\Entity\DataAbstractionLayer\Entity\EntityType\EntityTypeCollection;
use Ovv\Entity\DataAbstractionLayer\Entity\Entity\EntityCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCustomFieldsTrait;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class EntityRendererEntity extends Entity
{
    use EntityIdTrait;
    use EntityCustomFieldsTrait;

    protected int $autoIncrement;
    protected ?string $templateId = null;
    protected ?EntityTemplateEntity $template = null;
    protected ?bool $active = null;
    protected ?string $name = null;
    protected ?string $slug = null;
    protected ?string $description = null;
    protected ?EntityTypeCollection $types = null;
    protected ?EntityCollection $entities = null;

    public function getAutoIncrement(): int
    {
        return $this->autoIncrement;
    }

    public function setAutoIncrement(int $autoIncrement): void
    {
        $this->autoIncrement = $autoIncrement;
    }

    public function getTemplateId(): ?string
    {
        return $this->templateId;
    }

    public function setTemplateId(?string $templateId): void
    {
        $this->templateId = $templateId;
    }

    public function getTemplate(): ?EntityTemplateEntity
    {
        return $this->template;
    }

    public function setTemplate(?EntityTemplateEntity $template): void
    {
        $this->template = $template;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getTypes(): ?EntityTypeCollection
    {
        return $this->types;
    }

    public function setTypes(?EntityTypeCollection $types): void
    {
        $this->types = $types;
    }

    public function getEntities(): ?EntityCollection
    {
        return $this->entities;
    }

    public function setEntities(?EntityCollection $entities): void
    {
        $this->entities = $entities;
    }
}
