Feature: Public homepage

  Scenario: Homepage renders with key sections
    Given I am on the homepage
    Then the response status code should be 200
    And I should see "Skundų nagrinėjimo sistema"
    And I should see "Kaip tai veikia?"
    And I should see "Dažniausiai užduodami klausimai"
    And I should see "Prisijungti per el. valdžios vartus"

  Scenario: FAQ entries are shown ordered by position
    Given a faq exists with question "Trečias klausimas", answer "<p>Atsakymas C.</p>" and position "3"
    And a faq exists with question "Pirmas klausimas", answer "<p>Atsakymas A.</p>" and position "1"
    And a faq exists with question "Antras klausimas", answer "<p>Atsakymas B.</p>" and position "2"
    When I am on the homepage
    Then the FAQ questions should appear in this order:
      | Pirmas klausimas  |
      | Antras klausimas  |
      | Trečias klausimas |

  Scenario: FAQ answer HTML is sanitized before rendering
    Given a faq exists with question "Ar tai saugu?", answer "<p>Taip.</p><script>window.xssTriggered = true;</script><img src=x onerror='window.xssTriggered = true'>" and position "1"
    When I am on the homepage
    Then I should see "Ar tai saugu?"
    And the response should not contain "<script>"
    And the response should not contain "onerror"

  Scenario: Footer social links are hidden when none are configured
    Given I am on the homepage
    Then the response should not contain "aria-label=\"Facebook\""
    And the response should not contain "aria-label=\"Twitter\""
    And the response should not contain "aria-label=\"LinkedIn\""

  Scenario: Footer social link renders when configured
    Given a link exists with title "Facebook", key "facebook_link" and url "https://facebook.com/sis"
    When I am on the homepage
    Then the response should contain "https://facebook.com/sis"
    And the response should contain "aria-label=\"Facebook\""
    And the response should contain "target=\"_blank\""