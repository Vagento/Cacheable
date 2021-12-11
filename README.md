<h1 align="center">Vagento - Cacheable</h1>
<p>
  <img alt="Version" src="https://img.shields.io/badge/version-1.0.0-blue.svg?cacheSeconds=2592000" />
  <a href="https://opensource.org/licenses/MIT" target="_blank">
    <img alt="License: MIT" src="https://img.shields.io/badge/License-MIT-yellow.svg" />
  </a>
  <a href="https://twitter.com/WWoshid" target="_blank">
    <img alt="Twitter: WWoshid" src="https://img.shields.io/twitter/follow/WWoshid.svg?style=social" />
  </a>
</p>

> This package adds cacheability to method calls. It requires the Laravel framework.

## Installation

```sh
composer require vagento/cacheable
```

## Usage

<details>
<summary>
Trait: <b>Cacheable</b> - Method Cacheability
</summary>

Add the `\Vagento\Cacheable\Traits\Cacheable` trait to any class that needs the results of a method call to be cached.

```php
use Vagento\Cacheable\Traits\Cacheable;

class MyClass
{
    use Cacheable; // Add this trait
    
    public function myMethod()
    {
        // Big computational task
        return $bigData;
    }
}
```

Now you can call your method with the 'Cached' suffix like this:

```php
$myClass = new MyClass();

$result = $myClass->myMethodCached();
```

Optional parameters can be passed before the method call (Can be chained):

```php
$myClass = new MyClass();

// Optional: Cache usage, will toggle caching on or off
// Default: true
$myClass->setCacheUsage(false);

// Optional: Laravel cache tags @see https://laravel.com/docs/8.x/cache#cache-tags
// Default: null
$myClass->setCacheTags('my-method-tag');

// Optional: Time to live
// Default: null
$myClass->setTtl(60);
$myClass->setTtl(Carbon::now()->addMinutes(30)->toDateTime());

// Chaining
$result = $myClass->setCacheUsage(true)->setCacheTags(['method', 'something-else'])->setTtl(60)->myMethodCached();
```

For IDE support you can add the `@method` annotation to your class like this:

```php
/**
 * @method array myMethodCached()
 */
class MyClass
{
    use Cacheable;

    public function myMethod(): array
    {
        // Big computational task
        return $bigData;
    }
}
```
</details>

## Show your support

Give a ⭐️ if this project helped you!

## 📝 License

Copyright © 2021 [Valentin Wotschel](https://github.com/WalterWoshid).<br />
This project is [MIT](https://opensource.org/licenses/MIT) licensed.