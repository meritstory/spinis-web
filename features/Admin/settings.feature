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
    Given I submit the admin setting form with key "request_recipient_email" and value "requests@example.com"
    Given the admin settings list is open
    Given a setting with key "request_recipient_email" and value "requests@example.com" should exist in the database
    And I should see "Užklausų gavėjo el. paštas"
    And I should see "requests@example.com"

  Scenario: Creating a setting with an invalid email shows a validation error
    Given I open the admin create setting form
    Given I submit the admin setting form with key "request_recipient_email" and value "not-an-email"
    Given the admin setting form has an invalid email validation error

  Scenario: Used setting key is not available in the create dropdown
    Given a setting exists with key "request_recipient_email" and value "existing@example.com"
    Given I open the admin create setting form
    Given the admin create setting form should not show key "Užklausų gavėjo el. paštas"
    And I should see "Visi galimi nustatymai jau sukurti."

  Scenario: Configured request recipient email is used by the request mailer
    Given a setting exists with key "request_recipient_email" and value "requests@example.com"
    Given the request recipient email should be "requests@example.com"
