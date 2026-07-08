Feature: API docs

  Scenario: I can see API docs
    When I visit "/api/doc"
    Then the response status code should be 200
    And I should see "SPINIS API"
