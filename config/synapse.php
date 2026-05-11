<?php

return [
    'Synapse' => [
        'prompts' => [
            'cakephp_version' => env('MCP_CAKEPHP_VERSION', '5.x'),
            'php_version' => env('MCP_PHP_VERSION', PHP_VERSION),
            'quality_tools' => [
                'phpcs' => ['enabled' => true, 'standard' => 'cakephp'],
                'phpstan' => ['enabled' => true, 'level' => 8],
                'phpunit' => ['enabled' => true, 'coverage' => true],
                'rector' => ['enabled' => false, 'set' => 'cakephp'],
                'psalm' => ['enabled' => false, 'level' => 3],
            ],
        ],
    ],
];
