@javascript
Feature: Present five most used domains and files from log.
  Scenario: Tabs are rendered properly
    When I am on the homepage
    Then I should see "Varnish"
    And I should see "Articles"
    And I should see "Articles from json"


   Scenario Outline: The lists are sorted in descending order
     When I am on the homepage
     Then I should see "most visited hosts"
     And I should see 5 "<list-elements>" elements
     And the "<list-elements>" should be sorted descending

    Examples:
     |list-elements|
     |#varnish-tab ul:first-of-type li|
     |#varnish-tab ul:nth-of-type(2) li|