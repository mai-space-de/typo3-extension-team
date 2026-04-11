<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Mai Team',
    'description' => 'Team member records with name, role, bio, image, and contact links. Categories use TYPO3 sys_category.',
    'category' => 'module',
    'author' => 'Maispace',
    'author_email' => '',
    'state' => 'stable',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-14.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
