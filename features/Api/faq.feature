Feature: FAQ

  Scenario: I can list FAQs ordered by position
    Given faq with question "Kas yra SPINIS?", answer "<p>SPINIS yra sistema.</p>" and position 2 exists
    And faq with question "Kaip prisijungti?", answer "<p>Prisijunkite per portalą.</p>" and position 1 exists
    When I visit "/api/faq"
    Then the response status code should be 200
    And fetched response array should look like:
      | Property        | Value                          |
      | [0][position]   | 1                              |
      | [0][question]   | Kaip prisijungti?              |
      | [0][answer]     | <p>Prisijunkite per portalą.</p> |
      | [1][position]   | 2                              |
      | [1][question]   | Kas yra SPINIS?                |
      | [1][answer]     | <p>SPINIS yra sistema.</p>     |

  Scenario: I can list FAQs without authentication
    When I visit "/api/faq"
    Then the response status code should be 200
