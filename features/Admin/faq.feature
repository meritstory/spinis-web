Feature: Admin FAQ management

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And I confirm admin login with the latest authentication code for "admin@example.com"

  Scenario: FAQ list page shows create action
    When I visit the admin FAQ list page
    Then I should see "Sukurti DUK"
    And I should see "DUK"

  Scenario: Admin can create FAQ entry
    When I submit the FAQ form with question "Kaip pateikti skundą?" answer "<p>Skundą galite pateikti el. paštu.</p>" position "1"
    Then I should be on the admin FAQ list page
    And I should see "Kaip pateikti skundą?"

  Scenario: Empty answer shows validation error
    When I submit the FAQ form with question "Klausimas be atsakymo" answer "" position "1"
    Then I should be on the admin FAQ create page
    And I should see "Tekstas yra privalomas."

  Scenario: FAQ create page shows form fields
    When I visit the admin FAQ create page
    Then I should see "Pavadinimas"
    And I should see "Tekstas"
    And I should see "Pozicija"
