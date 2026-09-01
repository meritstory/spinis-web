Feature: FAQ page

  Scenario: FAQ page is reachable and renders
    Given I visit "/faq"
    And the response status code should be 200

  Scenario: Breadcrumb "Pagrindinis" link navigates to the homepage
    Given I am on "/faq"
    Given I follow "Pagrindinis"
    And I should be on the homepage

  Scenario: Header nav "D.U.K." link navigates to the FAQ page
    Given I am on the homepage
    Given I follow "D.U.K."
    And I should be on "/faq"

  Scenario: Homepage FAQ "Daugiau" link navigates to the FAQ page
    Given I am on the homepage
    Given I follow "Daugiau"
    And I should be on "/faq"

  Scenario: First FAQ entry is expanded on load
    Given faqs are loaded:
      | question           | answer              | position |
      | Pirmas klausimas   | <p>Atsakymas A.</p> | 1        |
      | Antras klausimas   | <p>Atsakymas B.</p> | 2        |
    Given I am on "/faq"
    Given the first FAQ answer should be expanded
    And the response should contain "Atsakymas A."

  Scenario: FAQ entries render ordered by position
    Given faqs are loaded:
      | question           | answer              | position |
      | Trečias klausimas  | <p>Atsakymas C.</p> | 3        |
      | Pirmas klausimas   | <p>Atsakymas A.</p> | 1        |
      | Antras klausimas   | <p>Atsakymas B.</p> | 2        |
    Given I am on "/faq"
    Given the FAQ questions should appear in this order:
      | Pirmas klausimas  |
      | Antras klausimas  |
      | Trečias klausimas |

  Scenario: FAQ answer HTML is sanitized before rendering
    Given faqs are loaded:
      | question      | answer                                                                                                   | position |
      | Ar tai saugu? | <p>Taip.</p><script>window.xssTriggered = true;</script><img src=x onerror='window.xssTriggered = true'> | 1        |
    Given I am on "/faq"
    And I should see "Ar tai saugu?"
    And the response should not contain "<script>"
    And the response should not contain "onerror"

  Scenario: "Still have questions" section is shown
    Given I visit "/faq"
    And I should see "Vis dar turite klausimų?"
    And I should see "Skambinti specialistui"
