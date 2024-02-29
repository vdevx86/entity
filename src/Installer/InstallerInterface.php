<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Installer;

use Shopware\Core\Framework\Plugin\Context\ActivateContext;

interface InstallerInterface
{
    public function activate(ActivateContext $context): void;
}
