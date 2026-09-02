Feature: Admin account management

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    And entity manager is cleared
    And I confirm admin login with the latest authentication code for "admin@example.com"

  Scenario: Accounts can be searched and sorted by translated role
    Given specialist with email "role-search@example.com" and password "secret" is created
    Given I search admin accounts for "Specialistas"
    Given I should see account "role-search@example.com" in the accounts list
    Given I visit the admin accounts list page
    Given I sort admin accounts by role
    And the response status code should be 200
    Given accounts should appear in this order:
      | role-search@example.com |
      | admin@example.com       |
    Given I sort admin accounts by role
    Given accounts should appear in this order:
      | admin@example.com       |
      | role-search@example.com |

  Scenario: System administrator can create a new account
    Given I create an admin account with email "specialist@example.com" first name "Jonas" last name "Jonaitis" role "specialist" and two-factor "enabled"
    Given I should be on the admin accounts page
    And I should see "Paskyra sukurta"
    Given I should see account "specialist@example.com" in the accounts list
    Given I visit the admin account detail page for "specialist@example.com"
    And I should see "Jonas"
    And I should see "Jonaitis"
    Given an invitation should exist for admin "specialist@example.com"

  Scenario: System administrator can create an account without two-factor authentication
    Given I create an admin account with email "no-2fa@example.com" first name "Jonas" last name "Jonaitis" role "specialist" and two-factor "disabled"
    Given I should be on the admin accounts page
    Given entity manager is cleared
    Given admin "no-2fa@example.com" should have two-factor disabled
    Given an invitation should exist for admin "no-2fa@example.com"

  Scenario: Creating account with duplicate email shows validation error
    Given admin with email "existing@example.com" and password "secret" is created
    Given I create an admin account with email "existing@example.com" first name "Petras" last name "Petraitis" role "specialist" and two-factor "enabled"
    And I should see "Paskyra su šiuo el. paštu jau egzistuoja."
    Given exactly one active admin account should exist with email "existing@example.com"

  Scenario: Account email uniqueness is case-insensitive
    Given admin with email "case@example.com" and password "secret" is created
    Given I create an admin account with email "CASE@EXAMPLE.COM" first name "Petras" last name "Petraitis" role "specialist" and two-factor "enabled"
    And I should see "Paskyra su šiuo el. paštu jau egzistuoja."
    Given exactly one active admin account should exist with email "case@example.com"

  Scenario: Creating account validates required email
    Given I create an admin account with email "" first name "Petras" last name "Petraitis" role "specialist" and two-factor "enabled"
    And I should see "El. paštas yra privalomas."

  Scenario: Creating account validates email format
    Given I create an admin account with email "invalid-email" first name "Petras" last name "Petraitis" role "specialist" and two-factor "enabled"
    And I should see "Neteisingas el. pašto formatas."
    Given admin account "invalid-email" should not exist

  Scenario: Creating account without names shows validation errors
    Given I create an admin account with email "noname@example.com" first name "" last name "" role "specialist" and two-factor "enabled"
    And I should see "Vardas yra privalomas."
    And I should see "Pavardė yra privaloma."

  Scenario: Creating account validates name fields reject numbers
    Given I create an admin account with invalid numeric name fields
    Given the account form shows name character validation errors

  Scenario: Editing account validates name fields reject numbers
    Given specialist with email "name-edit@example.com" and password "secret" is created
    Given I edit admin account "name-edit@example.com" setting first name to "Jonas123" and last name to "Jonaitis456"
    Given the account form shows name character validation errors

  Scenario: Creating account accepts hyphenated names with apostrophe
    Given I create an admin account with email "hyphen-name@example.com" first name "Marija-Saulė" last name "O'Brien" role "specialist" and two-factor "enabled"
    Given I should see account "hyphen-name@example.com" in the accounts list

  Scenario: Creating account rejects control whitespace in names
    Given I create an admin account with control whitespace in name fields
    Given the account form shows name character validation errors

  Scenario: Account create and edit forms use the same field order
    Given the admin account create form is open
    Given the account form fields appear in this order:
      | Vardas     |
      | Pavardė    |
      | El. paštas |
    Given specialist with email "field-order@example.com" and password "secret" is created
    Given the admin account edit form for "field-order@example.com" is open
    Given the account form fields appear in this order:
      | Vardas     |
      | Pavardė    |
      | El. paštas |

  Scenario: Accounts list supports pagination with configurable page size
    Given the admin accounts list page is open
    Given pagination controls are hidden on the single-page accounts list
    Given 11 specialist accounts exist for pagination testing
    Given the admin accounts list page is open
    Given the accounts list shows 10 rows
    Given pagination is visible on the accounts list
    Given the accounts paginator has accessible navigation states
    Given the accounts list page size selector shows options 10, 20, and 50
    Given the admin accounts list page is open with page size 20
    Given the accounts list shows 12 rows
    Given the admin accounts list page is open with page size 99
    Given the invalid page size warning is shown once

  Scenario: System administrator can edit account details
    Given specialist with email "editable@example.com" and password "secret" is created
    Given I edit admin account "editable@example.com" setting email to "updated@example.com" and active to "inactive"
    Given I should see account "updated@example.com" in the accounts list

  Scenario: System administrator can change an account role
    Given specialist with email "rolechange@example.com" and password "secret" is created
    Given I edit admin account "rolechange@example.com" changing role to "department_head"
    Given entity manager is cleared
    Given admin "rolechange@example.com" should have role "department_head"
    And I should see "Skyriaus vedėjas"

  Scenario: System administrator cannot remove their own account access
    Given I edit admin account "admin@example.com" changing role to "specialist"
    And I should see "Negalite panaikinti savo paskyros prieigos."
    Given admin "admin@example.com" should have role "system_admin"
    Given I delete admin account "admin@example.com"
    And I should see "Negalite panaikinti savo paskyros prieigos."
    Given admin "admin@example.com" should have role "system_admin"

  Scenario: Changing account role ends its existing session
    Given I visit the logout page
    Given specialist with email "active-rolechange@example.com" and password "secret" is created
    Given I submit the admin login form with email "active-rolechange@example.com" and password "secret"
    Given entity manager is cleared
    Given I confirm admin login with the latest authentication code for "active-rolechange@example.com"
    Given admin account "active-rolechange@example.com" has role changed directly to "department_head"
    Given I visit "/admin/faq"
    Given I should be on the admin login page
    Given I submit the admin login form with email "active-rolechange@example.com" and password "secret"
    Given entity manager is cleared
    Given I confirm admin login with the latest authentication code for "active-rolechange@example.com"
    Given I should be on the admin complaints list page
    And I should see "Skyriaus vedėjas"

  Scenario: Deactivated account during two-factor login is kicked out
    Given I visit the logout page
    Given specialist with email "mid2fa@example.com" and password "secret" is created
    Given I submit the admin login form with email "mid2fa@example.com" and password "secret"
    Given admin account "mid2fa@example.com" is deactivated for session invalidation
    Given I visit the admin two-factor login page
    Given I should be on the admin login page

  Scenario: Deactivated account cannot log in
    Given specialist with email "deactivated@example.com" and password "secret" is created
    Given I edit admin account "deactivated@example.com" setting email to "deactivated@example.com" and active to "inactive"
    Given I visit the logout page
    Given I submit the admin login form with email "deactivated@example.com" and password "secret"
    And I should see "Jūsų paskyra yra deaktyvuota. Dėl prieigos kreipkitės į sistemos administratorių."
    And I should not see "Autentifikacijos kodas"

  Scenario: Changing two-factor authentication ends old sessions and allows immediate login
    Given I visit the logout page
    Given specialist with email "twofactor-change@example.com" and password "secret" is created
    Given I submit the admin login form with email "twofactor-change@example.com" and password "secret"
    Given entity manager is cleared
    Given I confirm admin login with the latest authentication code for "twofactor-change@example.com"
    Given admin account "twofactor-change@example.com" has two-factor disabled directly
    Given I visit "/admin/faq"
    Given I should be on the admin login page
    Given I submit the admin login form with email "twofactor-change@example.com" and password "secret"
    Given I should be on the admin home page
    And I should not see "Autentifikacijos kodas"

  Scenario: Soft deletion ends an existing session on the next request
    Given I visit the logout page
    Given specialist with email "deleted-session@example.com" and password "secret" is created
    Given I submit the admin login form with email "deleted-session@example.com" and password "secret"
    Given entity manager is cleared
    Given I confirm admin login with the latest authentication code for "deleted-session@example.com"
    Given admin account "deleted-session@example.com" is soft deleted directly
    Given I visit "/admin/faq"
    Given I should be on the admin login page

  Scenario: Soft deleted account is not accessible by direct URL
    Given I create an admin account with email "hidden@example.com" first name "Ana" last name "Anaitė" role "specialist" and two-factor "enabled"
    Given a password reset token was issued for admin "hidden@example.com"
    Given I remember the account id for "hidden@example.com"
    Given I delete admin account "hidden@example.com"
    And I should see "Paskyra ištrinta"
    Given I visit the admin account detail page for the remembered account id
    And the response status code should be 404

  Scenario: Soft deleted account can be recreated with the same email
    Given I create an admin account with email "reusable@example.com" first name "Ana" last name "Anaitė" role "specialist" and two-factor "enabled"
    Given I delete admin account "reusable@example.com"
    Given I should not see account "reusable@example.com" in the accounts list
    Given entity manager is cleared
    Given admin account "reusable@example.com" should be soft deleted
    Given I create an admin account with email "reusable@example.com" first name "Ana" last name "Anaitė" role "specialist" and two-factor "enabled"
    Given I should see account "reusable@example.com" in the accounts list

  Scenario: System administrator can resend an expired account invitation
    Given I create an admin account with email "expired-resend@example.com" first name "Tomas" last name "Tomaitis" role "specialist" and two-factor "enabled"
    Given admin "expired-resend@example.com" has an expired account invitation
    Given I remember the invitation token hash for admin "expired-resend@example.com"
    Given I resend the account invitation for "expired-resend@example.com"
    And I should see "Pakvietimas išsiųstas iš naujo"
    Given I should be on the admin accounts page
    Given entity manager is cleared
    Given admin "expired-resend@example.com" should have a renewed invitation

  Scenario: Resend invitation is not shown after password setup with pending two-factor
    Given I create an admin account with email "partial-activate@example.com" first name "Tomas" last name "Tomaitis" role "specialist" and two-factor "enabled"
    Given admin "partial-activate@example.com" has a pending account invitation
    Given I visit the logout page
    Given I set the account invitation password to "Newsecretpass1!"
    Given I should be on the admin two-factor login page
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    Given entity manager is cleared
    Given I confirm admin login with the latest authentication code for "admin@example.com"
    Given I visit the admin accounts list page
    Given resend invitation should not be available for admin "partial-activate@example.com"

  Scenario: Password reset completes a pending account invitation
    Given I create an admin account with email "reset-pending@example.com" first name "Tomas" last name "Tomaitis" role "specialist" and two-factor "enabled"
    Given I visit the logout page
    Given a password reset token was issued for admin "reset-pending@example.com"
    Given I reset admin password using the stored reset token to "Newsecretpass1!"
    Given admin "reset-pending@example.com" has no pending account invitation

  Scenario: Changing a legacy pending account email renews its invitation
    Given changing legacy pending admin email from "legacy-old@example.com" to "legacy-new@example.com" renews its invitation

  Scenario: Changing a pending account email renews its invitation
    Given I create an admin account with email "old-invite@example.com" first name "Tomas" last name "Tomaitis" role "specialist" and two-factor "enabled"
    Given I remember the invitation token hash for admin "old-invite@example.com"
    Given I edit admin account "old-invite@example.com" setting email to "new-invite@example.com" and active to "active"
    Given entity manager is cleared
    Given admin "new-invite@example.com" should have a renewed invitation

  Scenario: Resending an invitation requires a valid CSRF token
    Given I create an admin account with email "csrf@example.com" first name "Tomas" last name "Tomaitis" role "specialist" and two-factor "enabled"
    Given I resend the account invitation for "csrf@example.com" without a valid CSRF token
    And the response status code should be 403

  Scenario: Invitation password must satisfy password policy
    Given I visit the logout page
    Given specialist with email "weak-password@example.com" and password "secret" is created
    Given admin "weak-password@example.com" has a pending account invitation
    Given I set the account invitation password to "weak"
    And the response should contain "<li>Slaptažodis turi būti bent 12 simbolių.</li>"
    And the response should contain "<li>Slaptažodyje turi būti bent viena didžioji raidė.</li>"
    And the response should contain "<li>Slaptažodyje turi būti bent vienas skaitmuo.</li>"
    And the response should contain "<li>Slaptažodyje turi būti bent vienas specialusis simbolis.</li>"
    Given an invitation should exist for admin "weak-password@example.com"

  Scenario: Invitation password setup redirects to two-factor login
    Given I visit the logout page
    Given specialist with email "activate@example.com" and password "secret" is created
    Given admin "activate@example.com" has a pending account invitation
    Given I set the account invitation password to "Newsecretpass1!"
    Given I should be on the admin two-factor login page
    Given I cancel admin two-factor authentication
    Given I open the account invitation link
    And I should see "Paskyros aktyvavimo nuoroda negalioja."

  Scenario: Invitation setup without two-factor logs in securely
    Given I visit the logout page
    Given specialist with email "activate-no-2fa@example.com" and password "secret" is created
    Given admin account "activate-no-2fa@example.com" has two-factor disabled directly
    Given admin "activate-no-2fa@example.com" has a pending account invitation
    Given I open the account invitation link
    Given I remember the current session id
    Given I set the account invitation password to "Newsecretpass1!"
    Given I should be on the admin home page
    Given the session id should have changed
    Given entity manager is cleared
    Given admin "activate-no-2fa@example.com" should have a last active time
    Given no invitation should exist for admin "activate-no-2fa@example.com"

  Scenario: Expired invitation token is rejected
    Given I visit the logout page
    Given specialist with email "expired-invitation@example.com" and password "secret" is created
    Given admin "expired-invitation@example.com" has an expired account invitation
    Given I open the account invitation link
    And I should see "Paskyros aktyvavimo nuoroda negalioja."

  Scenario: Non system administrator cannot access accounts page
    Given specialist with email "specialist@example.com" and password "secret" is created
    Given I visit the logout page
    Given I submit the admin login form with email "specialist@example.com" and password "secret"
    Given entity manager is cleared
    Given I confirm admin login with the latest authentication code for "specialist@example.com"
    Given I visit the admin accounts list page
    And the response status code should be 403
