Feature: About the system page

  Scenario: About page is reachable and renders
    When I visit "/about"
    Then the response status code should be 200

  Scenario: Breadcrumb "Pagrindinis" link navigates to the homepage
    Given I am on "/about"
    When I follow "Pagrindinis"
    Then I should be on the homepage

  Scenario: Header nav "Apie sistemą" link navigates to the about page
    Given I am on the homepage
    When I follow "Apie sistemą"
    Then I should be on "/about"

  Scenario: All sections are shown
    When I visit "/about"
    Then I should see "Kas mes esame?"
    And I should see "Kaip veikia sistema?"
    And I should see "Mūsų tikslai"
    And I should see "Teisinė bazė"
    And I should see "Turite skundą?"
    And I should see "Pateikti skundą"
