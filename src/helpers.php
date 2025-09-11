<?php

if (!function_exists('env')) {
    function env(string $key, mixed $default = null) {
        return \Crasivo\Bitrix\Dotenv\EnvLocator::getInstance()->get($key, $default);
    }
}
