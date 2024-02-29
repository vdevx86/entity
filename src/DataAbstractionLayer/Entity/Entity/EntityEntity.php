<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\Entity;

use Ovv\Entity\DataAbstractionLayer\Entity\EntityRenderer\EntityRendererCollection;
use Ovv\Entity\DataAbstractionLayer\Entity\EntityType\EntityTypeEntity;
use Ovv\Entity\DataAbstractionLayer\Entity\Entity\Aggregate\EntityMedia\EntityMediaCollection;
use Ovv\Entity\DataAbstractionLayer\Entity\Entity\Aggregate\EntityMedia\EntityMediaEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCustomFieldsTrait;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\System\CustomField\Aggregate\CustomFieldSet\CustomFieldSetCollection;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;

class EntityEntity extends Entity
{
    use EntityIdTrait;
    use EntityCustomFieldsTrait;

    protected int $autoIncrement;
    protected ?string $salesChannelId = null;
    protected ?SalesChannelEntity $salesChannel = null;
    protected ?string $typeId = null;
    protected ?EntityTypeEntity $type = null;
    protected ?string $mediaId = null;
    protected ?EntityMediaEntity $cover = null;
    protected ?EntityMediaCollection $media = null;
    protected ?bool $active = null;
    protected ?string $slug = null;
    protected ?string $name = null;
    protected ?string $description = null;
    protected ?CustomFieldSetCollection $customFieldSets = null;
    protected ?EntityRendererCollection $renderers = null;

    public function getAutoIncrement(): int
    {
        return $this->autoIncrement;
    }

    public function setAutoIncrement(int $autoIncrement): void
    {
        $this->autoIncrement = $autoIncrement;
    }

    public function getSalesChannelId(): ?string
    {
        return $this->salesChannelId;
    }

    public function setSalesChannelId(?string $salesChannelId): void
    {
        $this->salesChannelId = $salesChannelId;
    }

    public function getSalesChannel(): ?SalesChannelEntity
    {
        return $this->salesChannel;
    }

    public function setSalesChannel(?SalesChannelEntity $salesChannel): void
    {
        $this->salesChannel = $salesChannel;
    }

    public function getTypeId(): ?string
    {
        return $this->typeId;
    }

    public function setTypeId(?string $typeId): void
    {
        $this->typeId = $typeId;
    }

    public function getType(): ?EntityTypeEntity
    {
        return $this->type;
    }

    public function setType(?EntityTypeEntity $type): void
    {
        $this->type = $type;
    }

    public function getMediaId(): ?string
    {
        return $this->mediaId;
    }

    public function setMediaId(?string $mediaId): void
    {
        $this->mediaId = $mediaId;
    }

    public function getCover(): ?EntityMediaEntity
    {
        return $this->cover;
    }

    public function setCover(?EntityMediaEntity $cover): void
    {
        $this->cover = $cover;
    }

    public function getMedia(): ?EntityMediaCollection
    {
        return $this->media;
    }

    public function setMedia(?EntityMediaCollection $media): void
    {
        $this->media = $media;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): void
    {
        $this->active = $active;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getCustomFieldSets(): ?CustomFieldSetCollection
    {
        return $this->customFieldSets;
    }

    public function setCustomFieldSets(?CustomFieldSetCollection $customFieldSets): void
    {
        $this->customFieldSets = $customFieldSets;
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
