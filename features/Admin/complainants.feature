Feature: Admin complainants

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And entity manager is cleared
    And I confirm admin login with the latest authentication code for "admin@example.com"

  Scenario: Complainants section shows read-only list page
    Given a complainant exists with first name "Jonas" and last name "Jonaitis"
    When I open the admin complainants section from the menu
    Then the admin complainants list is open
    And complainant "Jonas" "Jonaitis" should be visible in the complainants list

  Scenario: Unauthenticated user is redirected to admin login
    Given a complainant exists with first name "Jonas" and last name "Jonaitis"
    When the admin session is cleared
    And I visit the admin complainants list page
    Then I should be on the admin login page

  Scenario: Complainants can be searched by name
    Given a complainant exists with first name "Unikali" and last name "Pavardė"
    And a complainant exists with first name "Kita" and last name "Asmuo"
    When I search admin complainants for "Unikali"
    Then complainant "Unikali" "Pavardė" should be visible in the complainants list
    And complainant "Kita" "Asmuo" should not be visible in the complainants list
    When I search admin complainants for "Pavardė"
    Then complainant "Unikali" "Pavardė" should be visible in the complainants list
    And complainant "Kita" "Asmuo" should not be visible in the complainants list

  Scenario: Complainants can be sorted by Lithuanian alphabet
    Given a complainant exists with first name "Antanas" and last name "Test"
    And a complainant exists with first name "Ądomas" and last name "Test"
    And a complainant exists with first name "Bronius" and last name "Test"
    And a complainant exists with first name "Cezaris" and last name "Test"
    And a complainant exists with first name "Česlovas" and last name "Test"
    And a complainant exists with first name "Ema" and last name "Test"
    And a complainant exists with first name "Ęrika" and last name "Test"
    And a complainant exists with first name "Ėla" and last name "Test"
    And a complainant exists with first name "Zita" and last name "Test"
    And a complainant exists with first name "Živilė" and last name "Test"
    When I visit the admin complainants list page
    And I sort admin complainants by first name
    Then complainants should appear in this order:
      | Živilė   |
      | Zita     |
      | Ėla      |
      | Ęrika    |
      | Ema      |
      | Česlovas |
      | Cezaris  |
      | Bronius  |
      | Ądomas   |
      | Antanas  |
    When I sort admin complainants by first name
    Then complainants should appear in this order:
      | Antanas  |
      | Ądomas   |
      | Bronius  |
      | Cezaris  |
      | Česlovas |
      | Ema      |
      | Ęrika    |
      | Ėla      |
      | Zita     |
      | Živilė   |

  Scenario: Complainants can be sorted by Lithuanian alphabet on last name
    Given a complainant exists with first name "Test" and last name "Antanas"
    And a complainant exists with first name "Test" and last name "Ądomas"
    And a complainant exists with first name "Test" and last name "Bronius"
    And a complainant exists with first name "Test" and last name "Cezaris"
    And a complainant exists with first name "Test" and last name "Česlovas"
    And a complainant exists with first name "Test" and last name "Ema"
    And a complainant exists with first name "Test" and last name "Ęrika"
    And a complainant exists with first name "Test" and last name "Ėla"
    And a complainant exists with first name "Test" and last name "Zita"
    And a complainant exists with first name "Test" and last name "Živilė"
    When I visit the admin complainants list page
    And I sort admin complainants by last name
    Then complainant last names should appear in this order:
      | Živilė   |
      | Zita     |
      | Ėla      |
      | Ęrika    |
      | Ema      |
      | Česlovas |
      | Cezaris  |
      | Bronius  |
      | Ądomas   |
      | Antanas  |
    When I sort admin complainants by last name
    Then complainant last names should appear in this order:
      | Antanas  |
      | Ądomas   |
      | Bronius  |
      | Cezaris  |
      | Česlovas |
      | Ema      |
      | Ęrika    |
      | Ėla      |
      | Zita     |
      | Živilė   |
    When I sort admin complainants by last name
    Then complainant last names should appear in this order:
      | Živilė   |
      | Zita     |
      | Ėla      |
      | Ęrika    |
      | Ema      |
      | Česlovas |
      | Cezaris  |
      | Bronius  |
      | Ądomas   |
      | Antanas  |

  Scenario: Complainants are sorted with Y between Į and J regardless of letter case
    Given a complainant exists with first name "Ignas" and last name "Test"
    And a complainant exists with first name "Įrangas" and last name "Test"
    And a complainant exists with first name "yga" and last name "Test"
    And a complainant exists with first name "Jonas" and last name "Test"
    And a complainant exists with first name "Saulius" and last name "Test"
    And a complainant exists with first name "šarūnas" and last name "Test"
    And a complainant exists with first name "Urtė" and last name "Test"
    And a complainant exists with first name "Ųla" and last name "Test"
    And a complainant exists with first name "Ūla" and last name "Test"
    When I visit the admin complainants list page
    And I sort admin complainants by first name
    Then complainants should appear in this order:
      | Ūla     |
      | Ųla     |
      | Urtė    |
      | šarūnas |
      | Saulius |
      | Jonas   |
      | yga     |
      | Įrangas |
      | Ignas   |
    When I sort admin complainants by first name
    Then complainants should appear in this order:
      | Ignas   |
      | Įrangas |
      | yga     |
      | Jonas   |
      | Saulius |
      | šarūnas |
      | Urtė    |
      | Ųla     |
      | Ūla     |

  Scenario: Complainant detail page opens from list
    Given a complainant exists with first name "Peržiūra" and last name "Testinė"
    When I visit the admin complainants list page
    And I open the admin complainant detail page for "Peržiūra" "Testinė"
    Then I should be on the admin complainant detail page for "Peržiūra" "Testinė"
