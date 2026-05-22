<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

ExtensionUtility::registerPlugin(
    'MaiTeam',
    'View',
    'LLL:EXT:mai_team/Resources/Private/Language/locallang_db.xlf:tt_content.CType.mai_team_view',
    'mai-content',
    'default',
    '',
    'FILE:EXT:mai_team/Configuration/FlexForms/TeamPlugin.xml',
);
