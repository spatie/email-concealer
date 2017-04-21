# Obfuscate e-mail addresses in a string

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/obfuscate-emails.svg?style=flat-square)](https://packagist.org/packages/spatie/obfuscate-emails)
[![Build Status](https://img.shields.io/travis/spatie/obfuscate-emails/master.svg?style=flat-square)](https://travis-ci.org/spatie/obfuscate-emails)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/xxxxxxxxx.svg?style=flat-square)](https://insight.sensiolabs.com/projects/xxxxxxxxx)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/obfuscate-emails.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/obfuscate-emails)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/obfuscate-emails.svg?style=flat-square)](https://packagist.org/packages/spatie/obfuscate-emails)

Obfuscate e-mail addresses in a string. Useful for obfuscating up production data—like MySQL dumps—so you can use it locally without worrying about having real addresses on your system.

```php
use Spatie\ObfuscateEmails\Obfuscator;

$obfuscator = Obfuscator::create();

$obfuscator->obfuscate('info@spatie.be');
// "info@example.com"
```

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Installation

You can install the package via composer:

``` bash
composer require spatie/obfuscate-emails
```

## Usage

To obfuscate a string, create an `Obfuscator` instance. and call the `obfuscate` method.

```php
use Spatie\ObfuscateEmails\Obfuscator;

$obfuscator = Obfuscator::create();

$obfuscator->obfuscate('info@spatie.be');
// "info@example.com"
```

The obfuscator processes every e-mail address it finds in the string. It will ensure that there aren't any unwanted duplicates if the local-part is the same. 

```php
$obfuscator->obfuscate('info@spatie.be,info@foo.com,info@bar.com');
// "info@example.com,info-1@foo.com,info-2@bar.com"
```

Equal e-mail addresses will always obfuscate to the same obfuscated address.

```php
$obfuscator->obfuscate('info@spatie.be,info@foo.com,info@spatie.be');
// "info@example.com,info-1@example.com,info@example.com"
```

If you want to use a different domain than `example.com`, use the `domain` method to set a new one.

```php
$obfuscator = Obfuscator::create()->domain('foo.com');

echo $obfuscator->obfuscate('info@spatie.be'); // "info@foo.com"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## About Spatie

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
