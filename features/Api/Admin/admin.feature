Feature: Admin

  Background:
    Given admin with email "admin@example.com" and password "test" is created
    And admin with email "admin@example.com" is authenticated

  Scenario: I can fetch my data
    When I fetch my data
    Then fetched response array should look like:
      | Property   | Value              |
      | [email] | admin@example.com |
