<?php declare(strict_types=1);
/*
 * @author Vazgen Ovakimyan
 * @link   https://www.linkedin.com/in/vdevx86
 */

namespace Ovv\Entity\Installer;

use Ovv\Entity\DataAbstractionLayer\Entity\Entity\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MediaInstaller extends AbstractInstaller
{
    final public const MEDIA_DEFAULT_FOLDER_ID = '018d863eefec7162b470be45a9e65498';
    final public const MEDIA_FOLDER_CONFIGURATION_ID = '018d863ef3897309accb8c0b44c3be1a';
    final public const MEDIA_FOLDER_ID = '018d863ef57070f59ee2200df19c0b43';

    private readonly EntityRepository $mediaDefaultFolderRepository;
    private readonly EntityRepository $mediaFolderConfigurationRepository;
    private readonly EntityRepository $mediaFolderRepository;

    public function __construct(ContainerInterface $container)
    {
        $this->mediaDefaultFolderRepository = $container->get('media_default_folder.repository');
        $this->mediaFolderConfigurationRepository = $container->get('media_folder_configuration.repository');
        $this->mediaFolderRepository = $container->get('media_folder.repository');
    }

    public function activate(ActivateContext $context): void
    {
        $context = $context->getContext();

        $defaultFolderId = self::MEDIA_DEFAULT_FOLDER_ID;

        if (!$this->entityExists($this->mediaDefaultFolderRepository, $defaultFolderId, $context)) {
            $this->mediaDefaultFolderRepository->create([[
                'id' => $defaultFolderId,
                'associationFields' => [],
                'entity' => EntityDefinition::ENTITY_NAME,
            ]], $context);
        }

        $configurationId = self::MEDIA_FOLDER_CONFIGURATION_ID;

        if (!$this->entityExists($this->mediaFolderConfigurationRepository, $configurationId, $context)) {
            $this->mediaFolderConfigurationRepository->create([[
                'id' => $configurationId,
            ]], $context);
        }

        $folderId = self::MEDIA_FOLDER_ID;

        if (!$this->entityExists($this->mediaFolderRepository, $folderId, $context)) {
            $this->mediaFolderRepository->create([[
                'id' => $folderId,
                'defaultFolderId' => $defaultFolderId,
                'name' => 'Entity',
                'configurationId' => $configurationId,
            ]], $context);
        }
    }
}
