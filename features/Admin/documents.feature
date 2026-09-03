Feature: Admin documents

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And entity manager is cleared
    And I confirm admin login with the latest authentication code for "admin@example.com"

  Scenario: Creating document without required fields shows validation errors
    When I open the admin create document form
    And I submit the admin document form without data
    Then the admin document form has required field validation errors

  Scenario: Creating a valid document redirects to the list with the new record
    When I open the admin create document form
    And I submit the admin document form with title "Privatumo politika" key "privacy_policy" and description "<p>Privatumo politikos turinys.</p>"
    Then the admin documents list is open
    And I should see "Dokumentas sukurtas"
    And a document with key "privacy_policy" and title "Privatumo politika" should exist in the database
    And the admin documents list shows "Privatumo politika"

  Scenario: Used document key is not available in the create dropdown
    Given documents are loaded:
      | title          | key            | description    |
      | Esama politika | privacy_policy | <p>Turinys</p> |
    When I open the admin create document form
    Then the admin create document form should not show key "Privatumo politika"

  Scenario: All document keys used shows empty dropdown message
    Given documents are loaded:
      | title          | key            | description         |
      | Esama politika | privacy_policy | <p>Turinys</p>      |
      | Apie mus       | about_system   | <p>Apie turinys</p> |
    When I open the admin create document form
    Then the admin create document form shows "Visi galimi raktai jau panaudoti."

  Scenario: Documents list search finds records by key label
    Given documents are loaded:
      | title    | key            | description    |
      | Politika | privacy_policy | <p>Turinys</p> |
    When I search the admin documents list for "Privatumo"
    Then the admin documents list shows "Privatumo politika" and "Politika"

  Scenario: Deleting a document removes it from the database
    Given documents are loaded:
      | title               | key            | description    |
      | Testinis dokumentas | privacy_policy | <p>Turinys</p> |
    When I delete the document with key "privacy_policy" from the admin index
    Then I should see "Dokumentas ištrintas"
    And a document with key "privacy_policy" should not exist in the database

  Scenario: Editing document key is allowed
    Given documents are loaded:
      | title    | key            | description    |
      | Politika | privacy_policy | <p>Turinys</p> |
    When I open the admin edit document form for key "privacy_policy"
    Then the admin edit document form allows changing the key
    And I submit the admin document edit form with key "about_system"
    Then I should see "Dokumentas atnaujintas"
    And a document with key "about_system" and title "Politika" should exist in the database
