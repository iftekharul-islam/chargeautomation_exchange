<?php
require_once __DIR__ . '/../../core/includes/autoload.php';

const DATABASE_ALIAS = ['cax_db' => 1, 'cax_logs_db' => 2];
const ACTION_ALIAS = ['create' => 1, 'alter' => 2];

const DATABASE = [
    'name' => 'db',
    'label' => 'Please Enter ' . DATABASE_ALIAS['cax_db'] . ' for main Database ' . DATABASE_ALIAS['cax_logs_db'] . ' for log Database: ',
    'rules' => [
        'NotEmpty' => ['message' => 'Database alias must be required. '],
        'InArray' => ['message' => 'Given database alias is invalid. ', 'allowed_values' => DATABASE_ALIAS]
    ]
];
const ACTION = [
    'name' => 'action',
    'label' => 'Please Enter ' . ACTION_ALIAS['create'] . ' for create ' . ACTION_ALIAS['alter'] . ' for alter: ',
    'rules' => [
        'NotEmpty' => ['message' => 'Action must be required. '],
        'InArray' => ['message' => 'Given action is invalid. ', 'allowed_values' => ACTION_ALIAS]
    ]
];
const TABLE_NAME = [
    'name' => 'table_name',
    'label' => 'Please Enter table name: ',
    'rules' => [
        'NotEmpty' => ['message' => 'Table name must be required. '],
        'NotSpecialCharacters' => ['message' => 'Special character not allowed. ']
    ]
];

?>