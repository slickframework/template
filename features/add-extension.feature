# add-extension.feature
  Feature: Add a custom extension
    In order to add more functionality to the template system
    As a developer
    I want to add extensions to the template engine when I initialize it

  Scenario: add custom extension
    Given I create a factory for "Twig" engine with no options
    And I append "templates" to the list of template paths
    And I add a custom extension
    And I initialize the template
    When I parse "extension.twig" and process:
      | foo | bar |
    Then I should get "Just BAR"