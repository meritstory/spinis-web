Feature: User

  Background:
    Given user with username "user@example.com" and password "test" is created
    And user with username "user@example.com" is authenticated

  Scenario: I can fetch my data
    When I fetch my data
    Then fetched response array should look like:
      | Property   | Value            |
      | [username] | user@example.com |
