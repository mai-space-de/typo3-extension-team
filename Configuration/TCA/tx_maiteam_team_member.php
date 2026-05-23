<?php

declare(strict_types=1);

use Maispace\MaiBase\TableConfigurationArray\FieldConfig\CategoryConfig;
use Maispace\MaiBase\TableConfigurationArray\FieldConfig\FileConfig;
use Maispace\MaiBase\TableConfigurationArray\FieldConfig\InputConfig;
use Maispace\MaiBase\TableConfigurationArray\FieldConfig\LinkConfig;
use Maispace\MaiBase\TableConfigurationArray\FieldConfig\NumberConfig;
use Maispace\MaiBase\TableConfigurationArray\FieldConfig\TextConfig;
use Maispace\MaiBase\TableConfigurationArray\Helper;
use Maispace\MaiBase\TableConfigurationArray\Table;

$lang = Helper::localLangHelperFactory('mai_team', 'Default/locallang_tca.xlf');

return (new Table($lang('table.tx_maiteam_team_member')))
    ->setDefaultConfig()
    ->setLabel('last_name')
    ->setAlternativeLabelFields('first_name')
    ->appendAlternativeLabelToLabel()
    ->setIconFile('EXT:mai_base/Resources/Public/Icons/generic_table.svg')
    ->setDefaultSorting('ORDER BY sorting ASC, last_name ASC')
    ->setThumbnailField('image')
    ->addColumn(
        'first_name',
        $lang('tx_maiteam_team_member.first_name'),
        (new InputConfig())->setSize(30)->setMax(100)->setEval('trim')->setRequired()
    )
    ->addColumn(
        'last_name',
        $lang('tx_maiteam_team_member.last_name'),
        (new InputConfig())->setSize(30)->setMax(100)->setEval('trim')->setRequired()
    )
    ->addColumn(
        'role',
        $lang('tx_maiteam_team_member.role'),
        (new InputConfig())->setSize(40)->setMax(255)->setEval('trim')
    )
    ->addColumn(
        'bio',
        $lang('tx_maiteam_team_member.bio'),
        (new TextConfig())->setCols(40)->setRows(6)->setEval('trim')->enableRte()->setRichtextConfiguration('default')
    )
    ->addColumn(
        'email',
        $lang('tx_maiteam_team_member.email'),
        (new InputConfig())->setSize(40)->setMax(255)->setEval('trim,nospace,lowercase')
    )
    ->addColumn(
        'phone',
        $lang('tx_maiteam_team_member.phone'),
        (new InputConfig())->setSize(20)->setMax(30)->setEval('trim')
    )
    ->addColumn(
        'linkedin',
        $lang('tx_maiteam_team_member.linkedin'),
        (new LinkConfig())
    )
    ->addColumn(
        'image',
        $lang('tx_maiteam_team_member.image'),
        (new FileConfig())
            ->setAllowed('common-image-types')
            ->setMaxItems(1)
            ->setAppearance([
                'createNewRelationLinkTitle' => $lang('tx_maiteam_team_member.image.addFile'),
            ])
    )
    ->addColumn(
        'sorting',
        $lang('tx_maiteam_team_member.sorting'),
        (new NumberConfig())->setDefault(0)
    )
    ->addColumn(
        'categories',
        $lang('tx_maiteam_team_member.categories'),
        (new CategoryConfig())
    )
    ->addPalette(
        'name',
        $lang('palette.name'),
        'first_name, last_name'
    )
    ->addPalette(
        'contact',
        $lang('palette.contact'),
        'email, phone'
    )
    ->addTypeShowItem(
        '0',
        '--palette--;;name, role, image,
        --div--;' . $lang('tab.bio') . ', bio,
        --div--;' . $lang('tab.contact') . ', --palette--;;contact, linkedin,
        --div--;' . $lang('tab.categories') . ', categories,
        --div--;' . $lang('tab.language') . ', --palette--;;language,
        --div--;' . $lang('tab.access') . ', --palette--;;hidden, --palette--;;access'
    )
    ->getConfig();
