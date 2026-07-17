Feature: VIISP login

  Scenario: Successful login lands on Mano skundai with a greeting
    Given VIISP will successfully authenticate personal code "38001010000" as "Jonas" "Jonaitis"
    When I complete VIISP login via login-submit
    Then I should be on "/mano-skundai"
    And I should see "Sveiki, Jonas"
    And a complainant with personal code "38001010000" should exist

  Scenario: Failed VIISP exchange shows the error modal on the homepage
    Given VIISP authentication will fail
    When I complete VIISP login via login-submit
    Then I should be on the homepage
    And I should see "Nepavyko prisijungti"
    And I should see "Bandyti dar kartą"

  Scenario: Unauthenticated direct access to Mano skundai redirects to login
    When I visit "/mano-skundai"
    Then I should be on "/viisp/login-submit"

  Scenario: Logout invalidates the session
    Given VIISP will successfully authenticate personal code "38001010000" as "Jonas" "Jonaitis"
    And I complete VIISP login via login-submit
    When I visit "/logout"
    And I visit "/mano-skundai"
    Then I should be on "/viisp/login-submit"
