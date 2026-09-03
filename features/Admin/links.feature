Feature: Admin links

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And entity manager is cleared
    And I confirm admin login with the latest authentication code for "admin@example.com"

  Scenario: Links section shows list page
    When I open the admin links section from the menu
    Then the admin links list is open

  Scenario: Creating link without required fields shows validation errors
    When I open the admin create link form
    And I submit the admin link form without data
    Then the admin link form has required field validation errors

  Scenario: Creating a valid link redirects to the list with the new record
    When I open the admin create link form
    And I submit the admin link form with title "Pagalba", key "help-page" and url "https://example.com/help"
    Then the admin links list is open
    And I should see "Nuoroda sukurta"
    And a link with key "help-page", title "Pagalba" and url "https://example.com/help" should exist in the database

  Scenario: Creating a link with an invalid url shows a validation error
    When I open the admin create link form
    And I submit the admin link form with title "Bloga nuoroda", key "bad-url" and url "google"
    Then the admin link form has an invalid url validation error

  Scenario: Creating a link with a duplicate key shows a validation error
    Given a link exists with title "Esama", key "duplicate-key" and url "https://example.com"
    When I open the admin create link form
    And I submit the admin link form with title "Kita", key "duplicate-key" and url "https://example.com/other"
    Then the admin link form has a duplicate key validation error
