Feature: Render three tabs which fetches and sorts data from various sources.

  Scenario: Tabs are rendered properly
    When I am on the homepage
    Then I should see "Varnish"
    And I should see "Articles"
    And I should see "Articles from json"

  # Assert('The articles should actually be sorted even though the task said nothing about it. It is top 5 after all.');
  @javascript
  Scenario Outline: Present five most used domains and files from log, sorted in descending order
    When I am on the homepage
    Then I should see "most visited hosts"
    And I should see 5 "<list-elements>" elements
    And the "<list-elements>" should be sorted descending

    Examples:
     |list-elements|
     |#varnish-tab ul:first-of-type li|
     |#varnish-tab ul:nth-of-type(2) li|

  @javascript
  Scenario: At least one article from rss-feed is properly rendered. Items are sorted descending.
    When I am on the homepage
    And I follow "Articles"
    And I wait 500000 microseconds for the animation
    Then I should see an "ul li" element
    And the articles in "#rss-tab ul li" should be sorted

  @javascript
  Scenario: At least one article from json-feed is rendered properly. Items should be sorted descending.
    When I am on the homepage
    And I follow "Articles from json"
    And I wait 500000 microseconds for the animation
    Then I should see an "ul li" element
    And the articles in "#json-tab ul li" should be sorted