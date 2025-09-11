<?php

declare(strict_types=1);

namespace Crasivo\Bitrix\Dotenv;

use Crasivo\Bitrix\Dotenv\Repository\Adapter\EnvAdapter;
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
        $this->repository = $repository ?? $this->createEnvRepository();
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
        return $this->repository->get($key) ?? $default;
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
        if (!is_dir($directory)) {
            $directory = $_SERVER['DOCUMENT_ROOT'];
        }

        // load & initialize environments
        @touch($directory . DIRECTORY_SEPARATOR . '.env');
        $dotenv = Dotenv::create($this->repository, $directory);
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
     * Returns the base repository with environment variables.
     *
     * @return RepositoryInterface
     */
    protected function createEnvRepository(): RepositoryInterface
    {
        return RepositoryBuilder::createWithNoAdapters()
            ->addAdapter(EnvAdapter::class)
            ->make();
    }
}
