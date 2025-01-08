Feature: Authentication

  Scenario: I can login and refresh token
    Given user with username "user@example.com" and password "test" is created
    When I create "POST" request to "/api/auth/login" with json:
    """
    {"username":"user@example.com","password":"test"}
    """
    And I submit the request
    Then the response status code should be 200
    And the response should contain:
      | token        | STRING |
      | refreshToken | STRING |
    When I refresh my token
    Then the response status code should be 200
    And the response should contain:
      | refreshToken | STRING |
