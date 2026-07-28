Feature: FAQ page

  Scenario: FAQ page is reachable and renders
    When I visit "/faq"
    Then the response status code should be 200

  Scenario: Breadcrumb "Pagrindinis" link navigates to the homepage
    Given I am on "/faq"
    When I follow "Pagrindinis"
    Then I should be on the homepage

  Scenario: Header nav "D.U.K." link navigates to the FAQ page
    Given I am on the homepage
    When I follow "D.U.K."
    Then I should be on "/faq"

  Scenario: Homepage FAQ "Daugiau" link navigates to the FAQ page
    Given I am on the homepage
    When I follow "Daugiau"
    Then I should be on "/faq"

  Scenario: First FAQ entry is expanded on load
    Given faqs exist:
      | question           | answer              | position |
      | Pirmas klausimas   | <p>Atsakymas A.</p> | 1        |
      | Antras klausimas   | <p>Atsakymas B.</p> | 2        |
    When I am on "/faq"
    Then the first FAQ answer should be expanded
    And the response should contain "Atsakymas A."

  Scenario: FAQ entries render ordered by position
    Given faqs exist:
      | question           | answer              | position |
      | Trečias klausimas  | <p>Atsakymas C.</p> | 3        |
      | Pirmas klausimas   | <p>Atsakymas A.</p> | 1        |
      | Antras klausimas   | <p>Atsakymas B.</p> | 2        |
    When I am on "/faq"
    Then the FAQ questions should appear in this order:
      | Pirmas klausimas  |
      | Antras klausimas  |
      | Trečias klausimas |

  Scenario: FAQ answer HTML is sanitized before rendering
    Given faqs exist:
      | question      | answer                                                                                                   | position |
      | Ar tai saugu? | <p>Taip.</p><script>window.xssTriggered = true;</script><img src=x onerror='window.xssTriggered = true'> | 1        |
    When I am on "/faq"
    Then I should see "Ar tai saugu?"
    And the response should not contain "<script>"
    And the response should not contain "onerror"

  Scenario: "Still have questions" section is shown
    When I visit "/faq"
    Then I should see "Vis dar turite klausimų?"
    And I should see "Skambinti specialistui"
