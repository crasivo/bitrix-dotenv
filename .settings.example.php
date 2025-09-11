<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

// load composer autoload
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

// load environments
Crasivo\Bitrix\Dotenv\EnvLocator::getInstance()->load();

return [
    'exception_handling' => [
        'value' => [
            'debug' => env('APP_DEBUG', false),
            'handled_errors_types' => E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE,
            'exception_errors_types' => E_ALL & ~E_NOTICE & ~E_WARNING & ~E_STRICT & ~E_USER_WARNING & ~E_USER_NOTICE & ~E_COMPILE_WARNING & ~E_DEPRECATED,
            'ignore_silence' => false,
            'assertion_throws_exception' => true,
            'assertion_error_type' => E_USER_ERROR,
            'log' => [
                'settings' => [
                    'file' => env('LOG_FILE_PATH', 'bitrix/error.log'),
                    'log_size' => env('LOG_FILE_SIZE', 10000000),
                ],
            ],
        ],
        'readonly' => true,
    ],
    'services' => [
        'value' => [
            Crasivo\Bitrix\Dotenv\EnvLocatorInterface::class => ['constructor' => function () {
                return Crasivo\Bitrix\Dotenv\EnvLocator::getInstance();
            }],
        ],
        'readonly' => true,
    ],
];
