Feature: Admin documents

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    Given I am logged in to the admin panel as "admin@example.com" with password "secret"

  Scenario: Creating document without required fields shows validation errors
    Given I open the admin create document form
    Given I submit the admin document form without data
    Given the admin document form has required field validation errors

  Scenario: Creating a valid document redirects to the list with the new record
    Given I open the admin create document form
    Given I submit the admin document form with title "Privatumo politika" key "privacy_policy" and description "<p>Privatumo politikos turinys.</p>"
    Given the admin documents list is open
    Given a document with key "privacy_policy" and title "Privatumo politika" should exist in the database
    And I should see "Privatumo politika"

  Scenario: Used document key is not available in the create dropdown
    Given a document exists with title "Esama politika" key "privacy_policy" and description "<p>Turinys</p>"
    Given I open the admin create document form
    Given the admin create document form should not show key "Privatumo politika"

  Scenario: All document keys used shows empty dropdown message
    Given a document exists with title "Esama politika" key "privacy_policy" and description "<p>Turinys</p>"
    And a document exists with title "Apie mus" key "about_system" and description "<p>Apie turinys</p>"
    Given I open the admin create document form
    And I should see "Visi galimi raktai jau panaudoti."

  Scenario: Documents list search finds records by key label
    Given a document exists with title "Politika" key "privacy_policy" and description "<p>Turinys</p>"
    Given I search the admin documents list for "Privatumo"
    Then I should see "Privatumo politika"
    And I should see "Politika"

  Scenario: Deleting a document removes it from the database
    Given a document exists with title "Testinis dokumentas" key "privacy_policy" and description "<p>Turinys</p>"
    When I delete the document with key "privacy_policy" from the admin index
    Then a document with key "privacy_policy" should not exist in the database
