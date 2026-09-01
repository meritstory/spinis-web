Feature: VIISP login

  Scenario: Successful login lands on My complaints with a greeting
    Given VIISP will successfully authenticate personal code "38001010000" as "Jonas" "Jonaitis"
    Given I complete VIISP login via login-submit
    And I should be on "/my-complaints"
    And I should see "Sveiki, Jonas"
    Given a complainant with personal code "38001010000" should exist

  Scenario: Failed VIISP exchange shows the error modal on the homepage
    Given VIISP authentication will fail
    Given I complete VIISP login via login-submit
    And I should be on the homepage
    And I should see "Nepavyko prisijungti"
    And I should see "Bandyti dar kartą"

  Scenario: Unauthenticated direct access to My complaints redirects to login
    Given I visit "/my-complaints"
    And I should be on "/viisp/login-submit"

  Scenario: Logout invalidates the session
    Given VIISP will successfully authenticate personal code "38001010000" as "Jonas" "Jonaitis"
    Given I complete VIISP login via login-submit
    Given I follow "Atsijungti"
    Given I visit "/my-complaints"
    And I should be on "/viisp/login-submit"
