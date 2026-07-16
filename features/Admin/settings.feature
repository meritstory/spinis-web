Feature: Admin settings

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    Given I am logged in to the admin panel as "admin@example.com" with password "secret"

  Scenario: Creating setting without required fields shows validation errors
    Given I open the admin create setting form
    Given I submit the admin setting form without data
    Given the admin setting form has required field validation errors

  Scenario: Creating a valid setting redirects to the list with the new record
    Given I open the admin create setting form
    Given I submit the admin setting form with key "version" and value "0.0.1"
    Given the admin settings list is open
    Given a setting with key "version" and value "0.0.1" should exist in the database
    And I should see "Versija"
    And I should see "0.0.1"

  Scenario: Used setting key is not available in the create dropdown
    Given a setting exists with key "version" and value "0.0.1"
    Given I open the admin create setting form
    Given the admin create setting form should not show key "Versija"
    And I should see "Visi galimi nustatymai jau sukurti."
