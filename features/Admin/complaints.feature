Feature: Admin complaints

  Background:
    Given department_head with email "head@example.com" and password "secret" is created without two-factor
    And I am logged in to the admin panel as "head@example.com" with password "secret" without two-factor

  Scenario: Department head lands on complaints list after login
    When I visit "/admin"
    Then I should be on the admin complaints list page
    And I should see "Skundai"
    And I should not see "DUK"

  Scenario: Complaints list shows complaint data
    Given a complaint exists with number "SK-2026-0001"
    And I visit the admin complaints list page
    Then I should see "SK-2026-0001"
    And I should see "Testinė poliklinika"
    And I should see "Jonas Jonaitis"
    And I should see "Pateiktas"

  Scenario: Complaints list search finds complaint by number
    Given a complaint exists with number "SK-2026-0002"
    And I search the admin complaints list for "SK-2026-0002"
    Then I should see "SK-2026-0002"

  Scenario: Empty complaints list shows no results message
    Given I visit the admin complaints list page
    Then I should see "Rezultatų nerasta."

  Scenario: System administrator cannot access complaints list
    Given I visit the logout page
    And admin with email "admin@example.com" and password "secret" is created
    And I am logged in to the admin panel as "admin@example.com" with password "secret"
    And I visit the admin complaints list page
    Then the response status code should be 403
    And I should see "Neturite teisės atlikti šio veiksmo."

  Scenario: Complaint edit page shows core sections for patient-submitted complaint
    Given a full complaint exists with number "SK-2026-EDIT-01"
    And I visit the admin complaint edit page for "SK-2026-EDIT-01"
    Then I should be on the admin complaint edit page for "SK-2026-EDIT-01"
    And I should see "Skundas SK-2026-EDIT-01"
    And I should see "Įstaigos informacija"
    And I should see "Įstaigai /-oms teikto skundo kopija ir įstaigos atsakymas /-ai"
    And I should see "Priskirtas specialistas"
    And I should see "Skundo informacija"
    And I should see "Skundo aplinkybės"
    And I should see "Skundo nagrinėjimo istorija"
    And I should see "Paciento informacija"
    And I should see "Paciento asmens dokumento kopija"
    And I should see "Testinė poliklinika"
    And I should see "Skundas pacientų teisių nustatymo tarnybai"
    And I should see "Pacientas"
    And I should see "Petras"
    And I should see "Pateiktas"
    And I should see "Skundo aprašymas test"
    And I should see "institution-copy.pdf"
    And I should see "PDF"
    And I should not see "Paciento atstovo /-ų informacija"
    And I should see "patient-id.pdf"
    And I should see "Papildyti skundą"
    And I should see "Teikti atsakymą pacientui"
    And I should see "Skundai"

  Scenario: Complaint attachment on edit page downloads via file_s3
    Given a full complaint exists with number "SK-2026-FILE-01"
    And I visit the admin complaint edit page for "SK-2026-FILE-01"
    When I download complaint attachment "patient-id.pdf" from the edit page
    Then the response status code should be 200
    And the last response should be a file_s3 download

  Scenario: Complaint edit page shows representative sections when submitted by representative
    Given a full complaint submitted by representative exists with number "SK-2026-REP-01"
    And I visit the admin complaint edit page for "SK-2026-REP-01"
    Then I should see "Teikia atstovaujantis asmuo"
    And I should see "Paciento atstovo /-ų informacija"
    And I should see "Atstovavimą patvirtinantys dokumentai"
    And I should see "Ona"
    And I should see "representation.pdf"

  Scenario: Complaints list opens edit page from row action
    Given a complaint exists with number "SK-2026-EDIT-03"
    And I visit the admin complaints list page
    When I open complaint "SK-2026-EDIT-03" from the complaints list
    Then I should be on the admin complaint edit page for "SK-2026-EDIT-03"

  Scenario: Saving complaint from edit page returns to list
    Given a complaint exists with number "SK-2026-SAVE-01"
    And I visit the admin complaint edit page for "SK-2026-SAVE-01"
    When I save complaint "SK-2026-SAVE-01" from the edit page and return to the list with status IN_REVIEW
    Then I should be on the admin complaints list page
    And I should see "Pakeitimai išsaugoti."
    And entity manager is cleared
    And complaint "SK-2026-SAVE-01" should have status IN_REVIEW
    And complaint "SK-2026-SAVE-01" should have 1 status history records

  Scenario: Saving complaint from edit page stays on edit
    Given a complaint exists with number "SK-2026-SAVE-02"
    And I visit the admin complaint edit page for "SK-2026-SAVE-02"
    When I save complaint "SK-2026-SAVE-02" from the edit page and continue editing with status IN_REVIEW
    Then I should be on the admin complaint edit page for "SK-2026-SAVE-02"
    And I should see "Pakeitimai išsaugoti."
    And entity manager is cleared
    And complaint "SK-2026-SAVE-02" should have status IN_REVIEW
    And complaint "SK-2026-SAVE-02" should have 1 status history records
    And I should see "Nagrinėjamas"

  Scenario: Complaint edit breadcrumb links to complaints list
    Given a complaint exists with number "SK-2026-BREAD-01"
    And I visit the admin complaint edit page for "SK-2026-BREAD-01"
    When I follow the complaints breadcrumb from the complaint edit page
    Then I should be on the admin complaints list page

  Scenario: Complaint edit page shows confirmation modals and save form actions
    Given a full complaint exists with number "SK-2026-MODAL-01"
    And I visit the admin complaint edit page for "SK-2026-MODAL-01"
    Then the complaint edit page should show action confirmation modal labels
    And the complaint edit page should show EasyAdmin save actions tied to the edit form

  Scenario: Cancel changes restores last saved status on edit page
    Given a complaint exists with number "SK-2026-CANCEL-01"
    And I visit the admin complaint edit page for "SK-2026-CANCEL-01"
    When I change complaint "SK-2026-CANCEL-01" status on the edit page to IN_REVIEW without saving
    And I cancel unsaved complaint changes on the edit page for "SK-2026-CANCEL-01"
    Then I should be on the admin complaint edit page for "SK-2026-CANCEL-01"
    And complaint "SK-2026-CANCEL-01" on the edit page should show status SUBMITTED

  Scenario: Complaint edit page shows guest patient snapshot without system user link
    Given a full complaint with guest patient snapshot exists with number "SK-2026-GUEST-01"
    And I visit the admin complaint edit page for "SK-2026-GUEST-01"
    Then I should see "Aistė"
    And I should see "Aistytė"
    And I should see "Teikia atstovaujantis asmuo"
    And I should see "Elena"
    And complaint "SK-2026-GUEST-01" should have a patient snapshot without linked complainant

  Scenario: Term date field uses calendar input with minimum today
    Given a full complaint exists with number "SK-2026-DATE-01"
    And I visit the admin complaint edit page for "SK-2026-DATE-01"
    Then the complaint edit page term date field should allow only future dates
