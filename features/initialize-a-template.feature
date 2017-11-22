# initialize-a-feature.feature
  Feature: Initialize a template engine
    In order to use a template engine
    As a developer
    I want to have a factory where I can set the engine options, paths and extensions
    and initialize a template engine

  Scenario: Creating a basic engine template
    Given I add "other-templates" to the list of template paths
    And I create a factory for "Twig" engine with no options
    When I initialize the template
    Then I should have a "Twig" template engine

  Scenario: Prepend paths
    Given I append "templates" to the list of template paths
    And I create a factory for "Twig" engine with no options
    When I initialize the template
    And I parse "alone.twig" and process:
      | foo | bar |
    Then I should get "Just bar"