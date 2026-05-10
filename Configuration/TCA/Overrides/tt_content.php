<?php

declare(strict_types=1);

defined('TYPO3') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'label' => 'LLL:EXT:mai_team/Resources/Private/Language/locallang_db.xlf:tt_content.CType.mai_team_view',
        'value' => 'mai_team_view',
        'icon' => 'EXT:mai_team/Resources/Public/Icons/ContentElement/TeamView.svg',
        'group' => 'default',
    ],
    'CType',
    'mai_team'
);

$GLOBALS['TCA']['tt_content']['types']['mai_team_view'] = [
    'showitem' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            header,
            pi_flexform,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
    ',
    'columnsOverrides' => [
        'pi_flexform' => [
            'label' => 'LLL:EXT:mai_team/Resources/Private/Language/locallang_db.xlf:tt_content.pi_flexform.mai_team_view',
            'config' => ['ds' => 'FILE:EXT:mai_team/Configuration/FlexForms/TeamPlugin.xml'],
        ],
    ],
];
