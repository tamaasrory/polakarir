<?php
return [
    'namespace' => 'App\Models',
    'base_class_name' => \App\Models\Base\SelfModel::class,
    'output_path' => 'Models/',
    'no_timestamps' => null,
    'date_format' => null,
    'connection' => null,
    'backup' => null,
    'model_defaults' => null,
    'db_types' => [
        'enum' => 'string',
    ],
];
