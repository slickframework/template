# Slick Template package

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Slick Template is a simple wrapper to a template engine of your choice. It defines
simple interfaces that allow you to create your own PHP template engines. It comes
with Twig template engine implementation, a flexible, fast, and secure template
engine for PHP.

This package is compliant with PSR-2 code standards and PSR-4 autoload standards. It
also applies the [semantic version 2.0.0](http://semver.org) specification.

## Install

Via Composer

``` bash
$ composer require slick/template
```

## Usage

### Configure template system

```php
use Slick\Template\Template;

Template::addPath('/path/to/twig/files');

$twig = (new Template(['engine' => Template::ENGINE_TWIG])->initialize();
```

Basically you need to set the path (or paths) where your `.twig` files
live and initialize the _Twig_ template engine.

### Create you Twig templates

Lets create a sample `index.html.twig` file in the folder that was
previously configured.

```twig
<h1>{{ post.title }}</h1>
<p>{{ post.teaser|nl2br }}</p>
```

#### Note

All documentation and API for twig can be accessed in the [Twig project home page](http://twig.sensiolabs.org/)

### Use the template

Now lets grab some data and create the HTML output using the _twig_ template:

```php
$data = [
    'post' => (object) [
        'title' => 'Sample blog post',
        'teaser' => 'Sample teaser for the blog post.'
    ]
];

$html = $template->parse('index.html.twig')
    ->process($data);

```

Output:

```html
<h1>Sample blog post\</h1>
<p>Sample teaser for the blog post.\</p>
```


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email slick.framework@gmail.com instead of using the issue tracker.

## Credits

- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/slick/template.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/slickframework/template/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/slickframework/template.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/slickframework/template.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/slick/template.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/slick/template
[link-travis]: https://travis-ci.org/slickframework/template
[link-scrutinizer]: https://scrutinizer-ci.com/g/slickframework/template/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/slickframework/template
[link-downloads]: https://packagist.org/packages/slickframework/template
[link-contributors]: https://github.com/slickframework/template/graphs/contributors

