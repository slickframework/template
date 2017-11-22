# simple-text-extension.feature
  Feature: Simple text extension
    In order to form text in an output string
    As a developer
    I want to have a way for truncate and wordwrap a given text

  Scenario: Truncate text
    Given I create a factory for "Twig" engine with no options
    And I initialize the template
    When I parse "truncate.twig" and process:
      | foo | bar bar bar |
    Then I should get "Just bar..."

  Scenario: Truncate text
    Given I create a factory for "Twig" engine with no options
    And I initialize the template
    When I parse "wordwrap.twig" and process:
      | foo | bar bar bar |
    Then I should get "Just bar*bar*bar"