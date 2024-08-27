# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]
## [v3.1.1] - 2024-08-27
### Added
- `generateWords()`,  `generateSentences()` and `generateParagraphs()` functions to the `Slick`
  template extension
- `path()` function to generate links between pages
- `SlickApp::settings()` to retrieve the application `SlickConfigurationInterface`
### Fixed
- Slick module enable/disable behavior

## [v3.1.0] - 2024-08-27
### Added
- `base.html.twig` as a base template that is aware of theme configuration
- Slick template extension: adds access to current user, request and settigns

### Fixed
- Markdown plugin on twig

## [v3.0.0] - 2024-08-23
### Added
- Error handler for `slick/error-handler` module
- New ``TemplateEngineInterface::sourceEngine()`` method to retrieve the underlying engine object
- ``TemplateMethods`` trait that you can use on controllers to return an HTTP response with content
  rendered from template engine.
- New implementation of ``TemplateEngineInterface`` to use `twig/twig` v3.x
- Module for Slick Framework that will integrate with `slick/di`,`slick/configuration`, and
  `slick/module-api`, allowing the usage of template engine.
- `phpunit/phpunit` as test framework
### Removed
- ``TemplateEngineInterface::setLocations()`` it should be do through module configuration
- `phpspec/phpspec` test suite. Tests were made with `phpunit/phpunit`
- support for php <= 8.1

## [v2.0.0] - 2023-02-22
### Added
- support for PHP 8.x
### Changed
- Now using ``twig/twig`` ver ^3.x
### Removed
- support to php <= 7.x
- travis.org pipeline

## [v1.3.0] - 2017-11-22

### Removed
- ``Slick\Template\EngineInterface`` it was deprecated and is removed.
- ``Slick\Exception\ParserException`` it would throw source engine exceptions instead.
- ``Slick\Common`` library dependency
- ``Slick\I18n`` dependency and extension

## [v1.2.5] - 2015-05-09

### Added
- Set default options to all instantiated engines on Template factory

## [v1.2.4] - 2015-04-27

### Fixed
- Custom extensions are now static lettings other clients to add extensions
  making them available for all initialized template engines.

## [v1.2.3] - 2015-04-04

### Added
- Added Template::register() method to register custom extensions.

## [v1.2.2] - 2015-02-22

### Fixed
- Dependency on ZEND-I18n Package

## [v1.2.1] - 2015-02-21

### Added
- Added twig debug extension when debug option is set to true.

## [v1.2.0] - 2015-02-10

### Added
- Support for extensions
- I18n extension
- Text extension

### Removed
- Twig extension

### Deprecated
- EngineInterface is now deprecated and should be replaced by
  TemplateEngineInterface for a more accurate meaning to the interface name.


## v1.1.0 - 2015-04-14

### Added
- Initial release

[Unreleased]: https://github.com/slickframework/template/compare/v3.1.1...HEAD
[v3.1.1]: https://github.com/slickframework/template/compare/v3.1.0...v3.1.1
[v3.1.0]: https://github.com/slickframework/template/compare/v3.0.0...v3.1.0
[v3.0.0]: https://github.com/slickframework/template/compare/v2.0.0...v3.0.0
[v2.0.0]: https://github.com/slickframework/template/compare/v1.3.0...v2.0.0
[v1.3.0]: https://github.com/slickframework/template/compare/v1.2.5...v1.3.0
[v1.2.5]: https://github.com/slickframework/template/compare/v1.2.4...v1.2.5
[v1.2.4]: https://github.com/slickframework/template/compare/v1.2.3...v1.2.4
[v1.2.3]: https://github.com/slickframework/template/compare/v1.2.2...v1.2.3
[v1.2.2]: https://github.com/slickframework/template/compare/v1.2.1...v1.2.2
[v1.2.1]: https://github.com/slickframework/template/compare/v1.2.0...v1.2.1
[v1.2.0]: https://github.com/slickframework/template/compare/v1.1.0...v1.2.0