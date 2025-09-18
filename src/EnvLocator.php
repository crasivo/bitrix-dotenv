<?php

declare(strict_types=1);

namespace Crasivo\Bitrix\Dotenv;

use Dotenv\Dotenv;
use Dotenv\Repository\RepositoryBuilder;
use Dotenv\Repository\RepositoryInterface;

class EnvLocator implements EnvLocatorInterface
{
    /** @var EnvLocatorInterface|null */
    private static $instance = null;

    /** @var RepositoryInterface */
    private $repository;

    /**
     * Locator constructor.
     *
     * @param RepositoryInterface|null $repository
     */
    public function __construct(?RepositoryInterface $repository = null)
    {
        $this->repository = $repository ?? RepositoryBuilder::createWithDefaultAdapters()->make();
    }

    /**
     * Singleton initializer.
     *
     * @return EnvLocatorInterface
     */
    public static function getInstance(): EnvLocatorInterface
    {
        return self::$instance ?? (self::$instance = new static());
    }

    /**
     * @inheritDoc
     */
    public function get(string $key, $default = null)
    {
        return ($value = $this->repository->get($key))
            ? $this->formatValue($value)
            : $default;
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return $this->repository->has($key);
    }

    /**
     * Loading environment variables from the specified directory.
     *
     * @param string|null $directory
     * @return void
     */
    public function load(?string $directory = null): void
    {
        $appEnv = $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? null;
        $dotenv = Dotenv::create(
            $this->repository,
            (is_string($directory) && is_dir($directory) ? [$directory] : [$_SERVER['DOCUMENT_ROOT']]),
            (is_string($appEnv) ? ['.env', '.env.' . $appEnv] : ['.env'])
        );
        $dotenv->load();
        @define('DOTENV_LOADED', true);
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, $value): void
    {
        $this->repository->set($key, $value);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    protected function formatValue($value)
    {
        switch (true) {
            case $value === 'null':
                return null;
            case in_array($value, ['true', 'false'], true):
                return $value === 'true';
            case is_numeric($value):
                return false !== strpos((string)$value, '.') ? floatval($value) : intval($value);
            default:
                return $value;
        }
    }
}
