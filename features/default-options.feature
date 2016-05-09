# default-options.feature
  Feature: Default options
    In order to set up default options in a given environment
    As a developer
    I want to set template default options that will be used in every engine instantiation

  Scenario: set debug option
    Given I set default option "debug" to "1"
    And I instantiate a template factory
    And I add "templates" to template locations
    And I run initialize on the template factory
    When I parse "options.twig" template file
    And I process:
      |key |value      |
      |data|Hello world|
    Then the output should contain:
      """
      vendor/twig/twig/lib/Twig/Extension/Debug.php:56:
      bool(true)
      """