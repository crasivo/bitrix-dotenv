📃 Bitrix Dotenv
===

Adapter for the popular [Dotenv](https://github.com/vlucas/phpdotenv) library for 1C-Bitrix & Bitrix24.

Implementation features:

- [x] Simple and quick integration into an existing project
- [x] Formatting of scalar values

<u>Minimum</u> requirements for installation:

- 1C-Bitrix kernel version (main): `v20.5.400`
- PHP version: `v7.2`
- Dotenv version: `v2.10`

# 🚀 Quick Start

To use the library (adapter), simply install the [Composer](https://getcomposer.org/) package via the command:

```shell
$ cd /path/to/project
$ composer require crasivo/bitrix-dotenv
```

It is initially assumed that `autoload.php` is already connected to your project.
If this is not the case, you can add it to one of the following files:

- `/bitrix/.settings.php`
- `/bitrix/.settings_extra.php`
- `/local/php_interface/init.php`

Next, you need to initialize the `EnvLocator` service (similar to the standard one) and load the environment variables.
Below is an example of initializing and loading environment variables.

```php
// document root
Crasivo\Bitrix\Dotenv\EnvLocator::getInstance()->load();
// specified dir
Crasivo\Bitrix\Dotenv\EnvLocator::getInstance()->load('/path/to/another/dir');
```

Access to values is via `EnvLocator` or via the helper function `env`.
Below are examples of working with environment variables.

```php
$envLocator = Crasivo\Bitrix\Dotenv\EnvLocator::getInstance();
echo $envLocator->get('LOG_LEVEL', 'debug'); // 'debug' (string)
echo $envLocator->get('APP_DEBUG', false); // true (bool)
echo $envLocator->get('SOME_INTEGER_PARAM'); // 415454 (integer)
echo $envLocator->get('SOME_FLOAT_PARAM'); // 154.69 (float)
```

Via the helper function:

```php
echo env('LOG_LEVEL', 'debug'); // 'debug' (string)
echo env('APP_DEBUG', false); // true (bool)
echo env('SOME_INTEGER_PARAM'); // 415454 (integer)
echo env('SOME_FLOAT_PARAM'); // 154.69 (float)
```

---

## 📜 License

This project is distributed under the [MIT](https://en.wikipedia.org/wiki/MIT_License) license.
The full text of the license can be read in the corresponding [file](LICENSE).
