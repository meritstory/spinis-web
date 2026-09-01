Feature: About the system page

  Scenario: About page is reachable and renders
    Given I visit "/about"
    And the response status code should be 200

  Scenario: Breadcrumb "Pagrindinis" link navigates to the homepage
    Given I am on "/about"
    Given I follow "Pagrindinis"
    And I should be on the homepage

  Scenario: Header nav "Apie sistemą" link navigates to the about page
    Given I am on the homepage
    Given I follow "Apie sistemą"
    And I should be on "/about"

  Scenario: All sections are shown
    Given I visit "/about"
    And I should see "Kas mes esame?"
    And I should see "Kaip veikia sistema?"
    And I should see "Mūsų tikslai"
    And I should see "Teisinė bazė"
    And I should see "Turite skundą?"
    And I should see "Pateikti skundą"
