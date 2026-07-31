Feature: Admin complaints

  Background:
    Given department_head with email "head@example.com" and password "secret" is created without two-factor
    And I am logged in to the admin panel as "head@example.com" with password "secret" without two-factor

  Scenario: Department head lands on complaints list after login
    When I visit "/admin"
    Then I should be on the admin complaints list page
    And I should see "Skundai"
    And I should not see "DUK"

  Scenario: Complaints list shows complaint data
    Given a complaint exists with number "SK-2026-0001"
    And I visit the admin complaints list page
    Then I should see "SK-2026-0001"
    And I should see "Testinė poliklinika"
    And I should see "Jonas Jonaitis"
    And I should see "Pateiktas"

  Scenario: Complaints list search finds complaint by number
    Given a complaint exists with number "SK-2026-0002"
    And I search the admin complaints list for "SK-2026-0002"
    Then I should see "SK-2026-0002"

  Scenario: Empty complaints list shows no results message
    Given I visit the admin complaints list page
    Then I should see "Rezultatų nerasta."

  Scenario: System administrator cannot access complaints list
    When I visit the logout page
    And admin with email "admin@example.com" and password "secret" is created
    And I am logged in to the admin panel as "admin@example.com" with password "secret"
    And I visit the admin complaints list page
    Then the response status code should be 403
