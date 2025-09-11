<?php

declare(strict_types=1);

namespace Crasivo\Bitrix\Dotenv\Repository\Adapter;

use Dotenv\Repository\Adapter\AdapterInterface;
use PhpOption\Option;
use PhpOption\Some;

class EnvAdapter implements AdapterInterface
{
    /**
     * Create a new env const adapter instance.
     *
     * @return void
     */
    private function __construct()
    {
        //
    }

    /**
     * Create a new instance of the adapter, if it is available.
     *
     * @return Option|Some
     */
    public static function create()
    {
        return Some::create(new static());
    }

    /**
     * Read an environment variable, if it exists.
     *
     * @param string $name
     * @return \PhpOption\None|Option|Some
     */
    public function read(string $name)
    {
        return Option::fromArraysValue($_ENV, $name)
            ->filter(static function ($value) {
                return is_scalar($value);
            })
            ->map(static function ($value) {
                switch (true) {
                    case in_array($value, ['true', 'false'], true):
                        return $value === 'true';
                    case $value === 'null':
                        return null;
                    case is_numeric($value):
                        return str_contains((string)$value, '.') ? (float)$value : (int)$value;
                    default:
                        return $value;
                }
            });
    }

    /**
     * Write to an environment variable, if possible.
     *
     * @param non-empty-string $name
     * @param string           $value
     *
     * @return bool
     */
    public function write(string $name, string $value)
    {
        $_ENV[$name] = $value;

        return true;
    }

    /**
     * Delete an environment variable, if possible.
     *
     * @param non-empty-string $name
     *
     * @return bool
     */
    public function delete(string $name)
    {
        unset($_ENV[$name]);

        return true;
    }
}
