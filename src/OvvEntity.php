<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity;

use Ovv\Entity\Installer\MediaInstaller;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;

class OvvEntity extends Plugin
{
    public function activate(ActivateContext $context): void
    {
        (new MediaInstaller($this->container))->activate($context);
    }
}
