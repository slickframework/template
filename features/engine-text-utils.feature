# engine-text-utils.feature
  Feature: Twig engine text utilities extension
    In order to have "truncate" and "wordwrap" filters available
      in the twig engine
    As a developer
    I want to have a text extension with those features available
      by default on engine initialization.

  Background: Having a template engine
    Given I instantiate a template factory
    And I add "templates" to template locations
    And I run initialize on the template factory

  Scenario: Truncate text
    Given I parse "truncate.twig" template file
    When I process:
      |key |value            |
      |data|test of truncate |
    Then the output should be "test of...";

  Scenario: Wordwrap
    Given I parse "wordwrap.twig" template file
    When I process:
      |key |value            |
      |data|test of wordwrap |
    Then the output should be "test\nof\nwordwrap";