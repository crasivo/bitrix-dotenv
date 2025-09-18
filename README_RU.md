📃 Bitrix Dotenv
===

Адаптер популярной библиотеки [Dotenv](https://github.com/vlucas/phpdotenv) для 1C-Bitrix & Bitrix24.

Особенности реализации:

- [x] Простое и быстрое внедрение в существующий проект
- [x] Форматирование скалярных значений

<u>Минимальные</u> требования для установки:

- Версия ядра 1C-Bitrix (main): `v20.5.400`
- Версия PHP: `v7.2`
- Версия Dotenv: `v5.0`

# 🚀 Быстрый старт

Для работы библиотеки (адаптера) достаточно установить [Composer](https://getcomposer.org/) пакет через команду:

```shell
$ cd /path/to/project
$ composer require crasivo/bitrix-dotenv
```

Изначально предполагается, что на вашем проекте уже подключен `autoload.php`.
Если это не так, то его можно добавить в одном из указанных файлов:

- `/bitrix/.settings.php`
- `/bitrix/.settings_extra.php`
- `/local/php_interface/init.php`

Далее необходимо инициализировать сервис `EnvLocator` (аналог штатного) и загрузить переменные окружения.
Ниже представлен пример инициализации и загрузки переменных окружения.

```php
// document root
Crasivo\Bitrix\Dotenv\EnvLocator::getInstance()->load();
// specified dir
Crasivo\Bitrix\Dotenv\EnvLocator::getInstance()->load('/path/to/another/dir');
```

Доступ к значениям осуществляется через `EnvLocator` или через helper-функцию `env`.
Ниже представлены примеры по работе с переменными окружения.

```php
$envLocator = Crasivo\Bitrix\Dotenv\EnvLocator::getInstance();
echo $envLocator->get('LOG_LEVEL', 'debug'); // 'debug' (string)
echo $envLocator->get('APP_DEBUG', false); // true (bool)
echo $envLocator->get('SOME_INTEGER_PARAM'); // 415454 (integer)
echo $envLocator->get('SOME_FLOAT_PARAM'); // 154.69 (float)
```

Через helper-функцию:

```php
echo env('LOG_LEVEL', 'debug'); // 'debug' (string)
echo env('APP_DEBUG', false); // true (bool)
echo env('SOME_INTEGER_PARAM'); // 415454 (integer)
echo env('SOME_FLOAT_PARAM'); // 154.69 (float)
```

---

## 📜 Лицензия

Данный проект распространяется по лицензии [MIT](https://en.wikipedia.org/wiki/MIT_License).
Полный текст лицензии можно прочитать в соответствующем [файле](LICENSE).
