Feature: Privacy policy page

  Scenario: Privacy policy page is reachable and renders
    When I visit "/privacy-policy"
    Then the response status code should be 200

  Scenario: Breadcrumb "Pagrindinis" link navigates to the homepage
    Given I am on "/privacy-policy"
    When I follow "Pagrindinis"
    Then I should be on the homepage

  Scenario: Header nav "Privatumo politika" link navigates to the privacy policy page
    Given I am on the homepage
    When I follow "Privatumo politika"
    Then I should be on "/privacy-policy"

  Scenario: Admin-managed content and last-updated date are shown
    Given documents are loaded:
      | title              | key            | description                                                                                    | updatedAt  |
      | Privatumo politika | privacy_policy | <h2>Duomenų valdytojas</h2><p>Šiame skyriuje aprašoma, kaip tvarkomi jūsų asmens duomenys.</p> | 2026-01-15 |
    When I visit "/privacy-policy"
    Then I should see "Duomenų valdytojas"
    And I should see "Šiame skyriuje aprašoma, kaip tvarkomi jūsų asmens duomenys."
    And I should see "2026-01-15"
