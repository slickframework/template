# translations.feature
  Feature: Use the Slick/I18n package
    In order to use internationalization
    As a developer
    I want to have a "translate" and "transPlural" functions on twig templates

    Background: Having a template engine
      Given I instantiate a template factory
      And I add "templates" to template locations
      And I run initialize on the template factory

    Scenario: Truncate text
      Given I parse "i18n.twig" template file
      When I process:
        |key |value      |
        |data|Hello world|
      Then the output should be "Olá mundo: 2 Utilizadores";