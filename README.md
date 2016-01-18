# Slick Template package

[![Latest Version](https://img.shields.io/github/release/slickframework/template.svg?style=flat-square)](https://github.com/slickframework/template/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/slickframework/template/master.svg?style=flat-square)](https://travis-ci.org/slickframework/template)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/slickframework/template/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/slickframework/template/code-structure?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/slickframework/template/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/slickframework/template?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/slick/template.svg?style=flat-square)](https://packagist.org/packages/slick/template)

Slick Template is a simple wrapper to a template engine of your choice. It defines
simple interfaces that allow you to create your own PHP template engines.
It comes with Twig template engine implementation, a flexible, fast, and secure
template engine for PHP.

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
$data = (object)[
    'title' => 'Sample blog post',
    'teaser' => 'Sample teaser for the blog post.'
];

$html = $template->parse('index.html.twig')
    ->process($data);

```

Output:

```html
<h1>Sample blog post\</h1>
<p>Sample teaser for the blog post.\</p>
```


## Testing

``` bash
$ vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email silvam.filipe@gmail.com instead of using the issue tracker.

## Credits

- [Slick framework](https://github.com/slickframework)
- [All Contributors](https://github.com/slickframework/common/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

