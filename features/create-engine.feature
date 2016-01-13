# create-engine.feature
  Feature: Create template engine to use
    I order to use twig as a template engine
    As a developer
    I want to have a "factory" class that given some settings
      it will create a template engine for me.

  Scenario: Create default twig engine
    Given I instantiate a template factory
    # paths are relative to features/bootstrap/Template dir
    And I add "templates" to template locations
    When I run initialize on the template factory
    Then I should get a "Slick\Template\Engine\Twig" object

  Scenario: Use a twig file as template
    Given I instantiate a template factory
    And I add "templates" to template locations
    And I run initialize on the template factory
    When I parse "test.twig" template file
    And I process:
      |key |value|
      |data|test |
    Then the output should be "Hello test";
