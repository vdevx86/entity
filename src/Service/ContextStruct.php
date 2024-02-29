<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Service;

use Shopware\Core\Framework\Struct\Struct;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Twig\Environment as TwigEnvironment;

class ContextStruct extends Struct
{
    protected ?SalesChannelContext $salesChannelContext = null;
    protected ?TwigEnvironment $twig = null;

    public function setSalesChannelContext(?SalesChannelContext $salesChannelContext): void
    {
        $this->salesChannelContext = $salesChannelContext;
    }

    public function getSalesChannelContext(): ?SalesChannelContext
    {
        return $this->salesChannelContext;
    }

    public function setTwig(?TwigEnvironment $twig): void
    {
        $this->twig = $twig;
    }

    public function getTwig(): ?TwigEnvironment
    {
        return $this->twig;
    }
}
