Feature: Admin FAQ management

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    And entity manager is cleared
    And I confirm admin login with the latest authentication code for "admin@example.com"

  Scenario: FAQ list page shows create action
    Given I visit the admin FAQ list page
    And I should see "Sukurti DUK"
    And I should see "DUK"

  Scenario: FAQ list can be filtered by creation and update dates
    Given I visit "/admin/faq/render-filters"
    And I should see "Sukūrimo data"
    And I should see "Atnaujinimo data"

  Scenario: Admin can create FAQ entry
    Given I submit the FAQ form with question "Kaip pateikti skundą?" answer "<p>Skundą galite pateikti el. paštu.</p>" position "1"
    Given I should be on the admin FAQ list page
    And I should see "DUK įrašas sukurtas"
    And I should see "Kaip pateikti skundą?"

  Scenario: Empty answer shows validation error
    Given I submit the FAQ form with question "Klausimas be atsakymo" answer "" position "1"
    Given I should be on the admin FAQ create page
    And I should see "Tekstas yra privalomas."

  Scenario: Duplicate position shows validation error
    Given I submit the FAQ form with question "Pirmas klausimas" answer "<p>Pirmas atsakymas.</p>" position "1"
    Given I submit the FAQ form with question "Antras klausimas" answer "<p>Antras atsakymas.</p>" position "1"
    Given I should be on the admin FAQ create page
    And I should see "Ši pozicija jau naudojama kitame DUK įraše."

  Scenario: FAQ create page shows form fields
    Given I visit the admin FAQ create page
    And I should see "Pavadinimas"
    And I should see "Tekstas"
    And I should see "Pozicija"
