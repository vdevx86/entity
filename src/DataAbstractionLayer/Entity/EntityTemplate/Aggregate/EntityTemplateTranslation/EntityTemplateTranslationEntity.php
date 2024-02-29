<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\DataAbstractionLayer\Entity\EntityTemplate\Aggregate\EntityTemplateTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\TranslationEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCustomFieldsTrait;

class EntityTemplateTranslationEntity extends TranslationEntity
{
    use EntityCustomFieldsTrait;

    protected ?string $name = null;
    protected ?string $template = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): void
    {
        $this->template = $template;
    }
}
