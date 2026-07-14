Feature: Admin links

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    Given I am logged in to the admin panel as "admin@example.com" with password "secret"

  Scenario: Links section shows list page
    Given I open the admin links section from the menu
    Given the admin links list is open

  Scenario: Creating link without required fields shows validation errors
    Given I open the admin create link form
    Given I submit the admin link form without data
    Given the admin link form has required field validation errors

  Scenario: Creating a valid link redirects to the list with the new record
    Given I open the admin create link form
    Given I submit the admin link form with title "Pagalba", key "help-page" and url "https://example.com/help"
    Given the admin links list is open
    Given a link with key "help-page", title "Pagalba" and url "https://example.com/help" should exist in the database

  Scenario: Creating a link with an invalid url shows a validation error
    Given I open the admin create link form
    Given I submit the admin link form with title "Bloga nuoroda", key "bad-url" and url "google"
    Given the admin link form has an invalid url validation error

  Scenario: Creating a link with a duplicate key shows a validation error
    Given a link exists with title "Esama", key "duplicate-key" and url "https://example.com"
    Given I open the admin create link form
    Given I submit the admin link form with title "Kita", key "duplicate-key" and url "https://example.com/other"
    Given the admin link form has a duplicate key validation error
