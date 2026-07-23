Feature: Admin settings

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    Given I am logged in to the admin panel as "admin@example.com" with password "secret"

  Scenario: Creating a setting without selecting a key shows a validation error
    Given I open the admin create setting form
    Given I submit the admin setting form without data
    Given the admin setting form has a key validation error

  Scenario: Creating a setting and then setting its value
    Given I create a setting with key "version"
    Given I submit the admin setting value "0.0.1"
    Given the admin settings list is open
    Given a setting with key "version" and value "0.0.1" should exist in the database
    And I should see "Versija"
    And I should see "0.0.1"

  Scenario: Used setting key is not available in the create dropdown
    Given a setting exists with key "version" and value "0.0.1"
    Given I open the admin create setting form
    Given the admin create setting form should not show key "Versija"
    And I should see "Sveikatos priežiūros įstaigų importavimo data"

  Scenario: Setting a health care institution import date value
    Given I create a setting with key "health_care_institution_import_from"
    Given I submit the admin setting value "2026-07-23T00:00"
    Given the admin settings list is open
    Given a setting with key "health_care_institution_import_from" and value "2026-07-23T00:00:00+03:00" should exist in the database
    And I should see "Sveikatos priežiūros įstaigų importavimo data"
    And I should see "2026-07-23 00:00"

  Scenario: Setting an invalid health care institution import date shows a validation error
    Given I create a setting with key "health_care_institution_import_from"
    Given I submit the admin setting value "not-a-date"
    Given the admin setting form has an invalid date validation error
