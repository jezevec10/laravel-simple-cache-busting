**INFO:** Project originally created by Ruyter licensed under MIT. The original repository is currently not available on GitHub.

---

# Laravel simple cache busting

This is a simple cachbusting for Laravel 5. It works with any static files like stylesheets, javascript files, and images. It appends asset urls with a unique hash. To generate a new hash you can trigger a artisan command or do it manually in the config!

## Install

Via Composer

``` bash
$ composer require ruyter/laravel-simple-cache-busting
```

## Usage

In order to use the cache busting packages you need to register the service provider within the application! Open up `config/app.php` and find the `providers` key.

```php
'providers' => array(
    Ruyter\CacheBusting\CacheBustingServiceProvider::class,
)
```

In order to use the cache busting package you must publish the package configuration by running the following artisan command.

```Javascript
php artisan vendor:publish --provider="Ruyter\CacheBusting\CacheBustingServiceProvider" --tag=config
```

For any asset url you want to be able to bust you must use the `CacheBusting::url($url)` facade. For example if you wanted to link to a stylesheet that is located at `/css/app.css` you need to add the following to your blade view.

```html
<link rel="stylesheet" href="{{ CacheBusting::url('/css/stylesheet.css') }}">
```

The output will be.

```html
<link rel="stylesheet" href="/css/stylesheet.css?c6e6a62d3cafaa88eecac28f1f34a6a8">
```

To Generate a new hash to purge the browser cache you can run the following artisan command. This will generate a new hash and update the config file. It's recommanded to use the artisan command to update the hash. It needs to be a valid MD5 32 character string with only numbers and letters.

```bash
$ php artisan cachebusting:generate
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Want to contribute? Great!

## License

The MIT License (MIT).

## Enjoy!

If you have any questions to ask or bugs to report, feel free to contact us...
