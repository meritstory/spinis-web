Feature: Admin complainants

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    Given I am logged in to the admin panel as "admin@example.com" with password "secret"

  Scenario: Complainants section shows read-only list page
    Given a complainant exists with first name "Jonas" and last name "Jonaitis"
    Given I open the admin complainants section from the menu
    Given the admin complainants list is open
    Given complainant "Jonas" "Jonaitis" should be visible in the complainants list

  Scenario: Unauthenticated user is redirected to admin login
    Given a complainant exists with first name "Jonas" and last name "Jonaitis"
    Given the admin session is cleared
    Given I visit the admin complainants list page
    Given I should be on the admin login page

  Scenario: Complainants can be searched by name
    Given a complainant exists with first name "Unikali" and last name "Pavardė"
    Given a complainant exists with first name "Kita" and last name "Asmuo"
    Given I search admin complainants for "Unikali"
    Given complainant "Unikali" "Pavardė" should be visible in the complainants list
    Given complainant "Kita" "Asmuo" should not be visible in the complainants list
    Given I search admin complainants for "Pavardė"
    Given complainant "Unikali" "Pavardė" should be visible in the complainants list
    Given complainant "Kita" "Asmuo" should not be visible in the complainants list

  Scenario: Complainants can be sorted by Lithuanian alphabet
    Given a complainant exists with first name "Antanas" and last name "Test"
    Given a complainant exists with first name "Ądomas" and last name "Test"
    Given a complainant exists with first name "Bronius" and last name "Test"
    Given a complainant exists with first name "Cezaris" and last name "Test"
    Given a complainant exists with first name "Česlovas" and last name "Test"
    Given a complainant exists with first name "Ema" and last name "Test"
    Given a complainant exists with first name "Ęrika" and last name "Test"
    Given a complainant exists with first name "Ėla" and last name "Test"
    Given a complainant exists with first name "Zita" and last name "Test"
    Given a complainant exists with first name "Živilė" and last name "Test"
    Given I visit the admin complainants list page
    Given I sort admin complainants by first name
    Given complainants should appear in this order:
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
    Given I sort admin complainants by first name
    Given complainants should appear in this order:
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
    Given a complainant exists with first name "Test" and last name "Ądomas"
    Given a complainant exists with first name "Test" and last name "Bronius"
    Given a complainant exists with first name "Test" and last name "Cezaris"
    Given a complainant exists with first name "Test" and last name "Česlovas"
    Given a complainant exists with first name "Test" and last name "Ema"
    Given a complainant exists with first name "Test" and last name "Ęrika"
    Given a complainant exists with first name "Test" and last name "Ėla"
    Given a complainant exists with first name "Test" and last name "Zita"
    Given a complainant exists with first name "Test" and last name "Živilė"
    Given I visit the admin complainants list page
    Given complainant last names should appear in this order:
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
    Given I sort admin complainants by last name
    Given complainant last names should appear in this order:
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
    Given I sort admin complainants by last name
    Given complainant last names should appear in this order:
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

  Scenario: Complainant detail page opens from list
    Given a complainant exists with first name "Peržiūra" and last name "Testinė"
    Given I visit the admin complainants list page
    Given I open the admin complainant detail page for "Peržiūra" "Testinė"
    Given I should be on the admin complainant detail page for "Peržiūra" "Testinė"
