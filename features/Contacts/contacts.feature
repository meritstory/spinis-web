Feature: Contacts page

  Scenario: Contacts page is reachable and renders
    When I visit "/contacts"
    Then the response status code should be 200

  Scenario: Breadcrumb "Pagrindinis" link navigates to the homepage
    Given I am on "/contacts"
    When I follow "Pagrindinis"
    Then I should be on the homepage

  Scenario: Header nav "Kontaktai" link navigates to the contacts page
    Given I am on the homepage
    When I follow "Kontaktai"
    Then I should be on "/contacts"

  Scenario: FAQ "Skambinti specialistui" link navigates to the contacts page
    Given I am on "/faq"
    When I follow "Skambinti specialistui"
    Then I should be on "/contacts"

  Scenario: Contact information section is shown
    When I visit "/contacts"
    Then I should see "Kontaktinė informacija"
    And I should see "Adresas"
    And I should see "A. Juozapavičiaus g. 9, Vilnius"
    And I should see "Darbo valandos"
    And I should see "I–V 8:00–17:00"

  Scenario: Email renders as a mailto link
    When I visit "/contacts"
    Then the response should contain "href=\"mailto:info@skundai.lt\""

  Scenario: Phone number renders as a tel link
    When I visit "/contacts"
    Then the response should contain "href=\"tel:+37052613777\""

  Scenario: "Have questions" section is shown
    When I visit "/contacts"
    Then I should see "Turite klausimų?"
    And I should see "Peržiūrėti D.U.K."