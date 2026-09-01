Feature: Contacts page

  Scenario: Contacts page is reachable and renders
    Given I visit "/contacts"
    And the response status code should be 200

  Scenario: Breadcrumb "Pagrindinis" link navigates to the homepage
    Given I am on "/contacts"
    Given I follow "Pagrindinis"
    And I should be on the homepage

  Scenario: Header nav "Kontaktai" link navigates to the contacts page
    Given I am on the homepage
    Given I follow "Kontaktai"
    And I should be on "/contacts"

  Scenario: FAQ "Skambinti specialistui" link navigates to the contacts page
    Given I am on "/faq"
    Given I follow "Skambinti specialistui"
    And I should be on "/contacts"

  Scenario: Contact information section is shown
    Given I visit "/contacts"
    And I should see "Kontaktinė informacija"
    And I should see "Adresas"
    And I should see "A. Juozapavičiaus g. 9, Vilnius"
    And I should see "Darbo valandos"
    And I should see "I–V 8:00–17:00"

  Scenario: Email renders as a mailto link
    Given I visit "/contacts"
    And the response should contain "href=\"mailto:info@skundai.lt\""

  Scenario: Phone number renders as a tel link
    Given I visit "/contacts"
    And the response should contain "href=\"tel:+37052613777\""

  Scenario: "Have questions" section is shown
    Given I visit "/contacts"
    And I should see "Turite klausimų?"
    And I should see "Peržiūrėti D.U.K."
