<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Service;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Twig\Environment as TwigEnvironment;

interface ContentProcessorInterface
{
    public const REGEXP_PLACEHOLDER_PREFIX = 'entity-renderer-';

    public function process(string &$content, TwigEnvironment $twig, SalesChannelContext $context): void;
}
