# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Removed
- ``Slick\Template\EngineInterface`` it was deprecated and is removed.
- ``Slick\Exception\ParserException`` it wold throw source engine exceptions instead.
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

[Unreleased]: https://github.com/slickframework/template/compare/v1.2.5...HEAD
[v1.2.5]: https://github.com/slickframework/template/compare/v1.2.4...v1.2.5
[v1.2.4]: https://github.com/slickframework/template/compare/v1.2.3...v1.2.4
[v1.2.3]: https://github.com/slickframework/template/compare/v1.2.2...v1.2.3
[v1.2.2]: https://github.com/slickframework/template/compare/v1.2.1...v1.2.2
[v1.2.1]: https://github.com/slickframework/template/compare/v1.2.0...v1.2.1
[v1.2.0]: https://github.com/slickframework/template/compare/v1.1.0...v1.2.0