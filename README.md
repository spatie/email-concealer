# Conceal e-mail addresses in a string

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/email-concealer.svg?style=flat-square)](https://packagist.org/packages/spatie/email-concealer)
[![Build Status](https://img.shields.io/travis/spatie/email-concealer/master.svg?style=flat-square)](https://travis-ci.org/spatie/email-concealer)
[![StyleCI](https://styleci.io/repos/88886061/shield?branch=master)](https://styleci.io/repos/88886061)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/email-concealer.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/email-concealer)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/email-concealer.svg?style=flat-square)](https://packagist.org/packages/spatie/email-concealer)

Conceal e-mail addresses in a string by replacing their domain. Useful for concealing up production data—like MySQL dumps—so you can use it locally without worrying about having real addresses on your system.

```php
use Spatie\EmailConcealer\Concealer;

$concealer = Concealer::create();

$concealer->conceal('info@spatie.be');
// "info@example.com"
```

## Support us

[![Image](https://github-ads.s3.eu-central-1.amazonaws.com/email-concealer.jpg)](https://spatie.be/github-ad-click/email-concealer)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Kruikstraat 22, 2018 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Installation

You can install the package via composer:

``` bash
composer require spatie/email-concealer
```

## Usage

To conceal a string, create an `Concealer` instance. and call the `conceal` method.

```php
use Spatie\EmailConcealer\Concealer;

$concealer = Concealer::create();

$concealer->conceal('info@spatie.be');
// "info@example.com"
```

The concealer processes every e-mail address it finds in the string. It will ensure that there aren't any unwanted duplicates if the local-part is the same. 

```php
$concealer->conceal('info@spatie.be,info@foo.com,info@bar.com');
// "info@example.com,info-1@foo.com,info-2@bar.com"
```

Equal e-mail addresses will always conceal to the same concealed address.

```php
$concealer->conceal('info@spatie.be,info@foo.com,info@spatie.be');
// "info@example.com,info-1@example.com,info@example.com"
```

If you want to use a different domain than `example.com`, use the `domain` method to set a new one.

```php
$concealer = Concealer::create()->domain('foo.com');

echo $concealer->conceal('info@spatie.be'); // "info@foo.com"
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
