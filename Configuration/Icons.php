<?php

declare(strict_types=1);

$allIcons = 'EXT:mai_base/Resources/Public/Icons/all-icons/';

return [
    'ext-maispace-mai_team' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:mai_team/Resources/Public/Icons/Extension.svg',
    ],
    'mai-team' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => $allIcons . 'interface-user-multiple--close-geometric-human-multiple-person-up-user--Streamline-Core.svg',
    ],
    'tx-maiteam-teammember' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => $allIcons . 'interface-user-multiple--close-geometric-human-multiple-person-up-user--Streamline-Core.svg',
    ],
];
