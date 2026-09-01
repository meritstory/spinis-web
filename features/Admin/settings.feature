Feature: Admin settings

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    And entity manager is cleared
    And I confirm admin login with the latest authentication code for "admin@example.com"

  Scenario: Creating a setting without selecting a key shows a validation error
    Given I open the admin create setting form
    Given I submit the admin setting form without data
    Given the admin setting form has a key validation error

  Scenario: Creating a setting and then setting its value
    Given I create a setting with key "version"
    And I should see "Įrašas sukurtas"
    Given I submit the admin setting value "0.0.1"
    Given the admin settings list is open
    And I should see "Pakeitimai išsaugoti"
    Given entity manager is cleared
    Given a setting with key "version" and value "0.0.1" should exist in the database
    And I should see "Versija"
    And I should see "0.0.1"

  Scenario: Creating request recipient email setting shows the option and saves value
    Given I create a setting with key "request_recipient_email"
    Given I submit the admin setting value "requests@example.com"
    Given the admin settings list is open
    Given entity manager is cleared
    Given a setting with key "request_recipient_email" and value "requests@example.com" should exist in the database
    And I should see "Užklausų gavėjo el. paštas"
    And I should see "requests@example.com"

  Scenario: Creating a setting with an invalid email shows a validation error
    Given I create a setting with key "request_recipient_email"
    Given I submit the admin setting value "not-an-email"
    Given the admin setting edit form has a validation error "Įveskite galiojantį el. pašto adresą."
    Given a setting with key "request_recipient_email" should not appear in the settings list

  Scenario: Submitting blank value with save and continue shows a validation error on the edit form
    Given I create a setting with key "version"
    Given I submit the admin setting value "" and continue editing
    Given the admin setting edit form has a validation error "Įveskite reikšmę."
    Given a setting with key "version" should not appear in the settings list

  Scenario: Abandoned draft resumes when creating the same setting again
    Given I create a setting with key "version"
    Given I open the admin create setting form
    Given I submit the admin setting form with key "version"
    Given I should be on the admin setting edit page for key "version"

  Scenario: Abandoned draft does not appear in settings search results
    Given I create a setting with key "version"
    Given I search the admin settings list for "Versija"
    Given the admin settings list should not show setting key label "Versija"

  Scenario: Used setting key is not available in the create dropdown
    Given a setting exists with key "version" and value "0.0.1"
    Given I open the admin create setting form
    Given the admin create setting form should not show key "Versija"
    And I should see "Užklausų gavėjo el. paštas"
    And I should see "Sveikatos priežiūros įstaigų importavimo data"

  Scenario: Setting a health care institution import date value
    Given I create a setting with key "health_care_institution_import_from"
    Given I submit the admin setting value "2026-07-23T00:00"
    Given the admin settings list is open
    Given entity manager is cleared
    Given a setting with key "health_care_institution_import_from" and value "2026-07-23T00:00:00+00:00" should exist in the database
    And I should see "Sveikatos priežiūros įstaigų importavimo data"
    And I should see "2026-07-23 00:00"

  Scenario: Setting an invalid health care institution import date shows a validation error
    Given I create a setting with key "health_care_institution_import_from"
    Given I submit the admin setting value "not-a-date"
    Given the admin setting edit form has a validation error "Įveskite teisingą datą."
    Given a setting with key "health_care_institution_import_from" should not appear in the settings list

  Scenario: Submitting blank version value shows a validation error on the edit form
    Given I create a setting with key "version"
    Given I submit the admin setting value ""
    Given the admin setting edit form has a validation error "Įveskite reikšmę."
    Given a setting with key "version" should not appear in the settings list

  Scenario: Submitting blank import date shows a validation error on the edit form
    Given I create a setting with key "health_care_institution_import_from"
    Given I submit the admin setting value ""
    Given the admin setting edit form has a validation error "Įveskite teisingą datą."
    Given a setting with key "health_care_institution_import_from" should not appear in the settings list

  Scenario: All setting types used shows empty state with back link
    Given settings exist for all setting keys
    Given I open the admin create setting form
    Given the admin create setting form shows "Visi galimi nustatymai jau sukurti."
    And I should see "Grįžti į nustatymus"
    Given the admin create setting form should not have a key field
    Given the admin create setting form should not have a continue button

  Scenario: Settings list can be sorted by value
    Given a setting exists with key "version" and value "0.0.2"
    Given a setting exists with key "health_care_institution_import_from" and value "2026-07-23T00:00:00+00:00"
    Given I sort admin settings by value
    Given settings should appear in value order "2026-07-23 00:00" then "0.0.2"

  Scenario: Settings list search highlights matching keyword
    Given a setting exists with key "version" and value "1.0.0"
    Given I search the admin settings list for "Versija"
    Given the admin settings list should highlight "Versija"
