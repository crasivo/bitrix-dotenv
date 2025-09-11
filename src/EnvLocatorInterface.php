<?php

declare(strict_types=1);

namespace Crasivo\Bitrix\Dotenv;

interface EnvLocatorInterface
{
    /**
     * Returns the formatted value of the environment variable.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed|void
     */
    public function get(string $key, $default = null);

    /**
     * Returns `true` if the specified environment variable is set.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @internal
     *
     * @param string $key
     * @param mixed $value
     * @return mixed|void
     */
    public function set(string $key, $value);
}
