Feature: Admin account management

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And I confirm admin login with the latest authentication code for "admin@example.com"

  Scenario: Accounts can be searched and sorted by translated role
    Given specialist with email "role-search@example.com" and password "secret" is created
    When I search admin accounts for "Specialistas"
    Then I should see account "role-search@example.com" in the accounts list
    When I visit the admin accounts list page
    And I sort admin accounts by role
    Then the response status code should be 200
    And accounts should appear in this order:
      | role-search@example.com |
      | admin@example.com       |
    When I sort admin accounts by role
    Then accounts should appear in this order:
      | admin@example.com       |
      | role-search@example.com |

  Scenario: System administrator can create a new account
    When I create an admin account with email "specialist@example.com" first name "Jonas" last name "Jonaitis" role "specialist" and two-factor "enabled"
    Then I should be on the admin accounts page
    And I should see account "specialist@example.com" in the accounts list
    When I visit the admin account detail page for "specialist@example.com"
    Then I should see "Jonas"
    And I should see "Jonaitis"
    And an invitation should exist for admin "specialist@example.com"

  Scenario: System administrator can create an account without two-factor authentication
    When I create an admin account with email "no-2fa@example.com" first name "Jonas" last name "Jonaitis" role "specialist" and two-factor "disabled"
    Then I should be on the admin accounts page
    And admin "no-2fa@example.com" should have two-factor disabled
    And an invitation should exist for admin "no-2fa@example.com"

  Scenario: Creating account with duplicate email shows validation error
    Given admin with email "existing@example.com" and password "secret" is created
    When I create an admin account with email "existing@example.com" first name "Petras" last name "Petraitis" role "specialist" and two-factor "enabled"
    Then I should see "Paskyra su šiuo el. paštu jau egzistuoja."
    And exactly one active admin account should exist with email "existing@example.com"

  Scenario: Account email uniqueness is case-insensitive
    Given admin with email "case@example.com" and password "secret" is created
    When I create an admin account with email "CASE@EXAMPLE.COM" first name "Petras" last name "Petraitis" role "specialist" and two-factor "enabled"
    Then I should see "Paskyra su šiuo el. paštu jau egzistuoja."
    And exactly one active admin account should exist with email "case@example.com"

  Scenario: Creating account validates required email
    When I create an admin account with email "" first name "Petras" last name "Petraitis" role "specialist" and two-factor "enabled"
    Then I should see "El. paštas yra privalomas."

  Scenario: Creating account validates email format
    When I create an admin account with email "invalid-email" first name "Petras" last name "Petraitis" role "specialist" and two-factor "enabled"
    Then I should see "Neteisingas el. pašto formatas."
    And admin account "invalid-email" should not exist

  Scenario: Creating account without names shows validation errors
    When I create an admin account with email "noname@example.com" first name "" last name "" role "specialist" and two-factor "enabled"
    Then I should see "Vardas yra privalomas."
    And I should see "Pavardė yra privaloma."

  Scenario: System administrator can edit account details
    Given specialist with email "editable@example.com" and password "secret" is created
    When I edit admin account "editable@example.com" setting email to "updated@example.com" and active to "inactive"
    Then I should see account "updated@example.com" in the accounts list

  Scenario: System administrator can change an account role
    Given specialist with email "rolechange@example.com" and password "secret" is created
    When I edit admin account "rolechange@example.com" changing role to "department_head"
    Then admin "rolechange@example.com" should have role "department_head"
    And I should see "Skyriaus vedėjas"

  Scenario: System administrator cannot remove their own account access
    When I edit admin account "admin@example.com" changing role to "specialist"
    Then I should see "Negalite panaikinti savo paskyros prieigos."
    And admin "admin@example.com" should have role "system_admin"
    When I delete admin account "admin@example.com"
    Then I should see "Negalite panaikinti savo paskyros prieigos."
    And admin "admin@example.com" should have role "system_admin"

  Scenario: Changing account role ends its existing session
    When I visit the logout page
    Given specialist with email "active-rolechange@example.com" and password "secret" is created
    When I submit the admin login form with email "active-rolechange@example.com" and password "secret"
    And I confirm admin login with the latest authentication code for "active-rolechange@example.com"
    And admin account "active-rolechange@example.com" has role changed directly to "department_head"
    When I visit "/admin/faq"
    Then I should be on the admin login page
    When I submit the admin login form with email "active-rolechange@example.com" and password "secret"
    And I confirm admin login with the latest authentication code for "active-rolechange@example.com"
    Then I should be on the admin FAQ page
    And I should see "Skyriaus vedėjas"

  Scenario: Deactivated account during two-factor login is kicked out
    When I visit the logout page
    Given specialist with email "mid2fa@example.com" and password "secret" is created
    When I submit the admin login form with email "mid2fa@example.com" and password "secret"
    And admin account "mid2fa@example.com" is deactivated for session invalidation
    When I visit the admin two-factor login page
    Then I should be on the admin login page

  Scenario: Deactivated account cannot log in
    Given specialist with email "deactivated@example.com" and password "secret" is created
    When I edit admin account "deactivated@example.com" setting email to "deactivated@example.com" and active to "inactive"
    And I visit the logout page
    When I submit the admin login form with email "deactivated@example.com" and password "secret"
    Then I should see "Neteisingi prisijungimo duomenys."
    And I should not see "Autentifikacijos kodas"

  Scenario: Changing two-factor authentication ends old sessions and allows immediate login
    When I visit the logout page
    Given specialist with email "twofactor-change@example.com" and password "secret" is created
    When I submit the admin login form with email "twofactor-change@example.com" and password "secret"
    And I confirm admin login with the latest authentication code for "twofactor-change@example.com"
    And admin account "twofactor-change@example.com" has two-factor disabled directly
    When I visit "/admin/faq"
    Then I should be on the admin login page
    When I submit the admin login form with email "twofactor-change@example.com" and password "secret"
    Then I should be on the admin FAQ page
    And I should not see "Autentifikacijos kodas"

  Scenario: Soft deletion ends an existing session on the next request
    When I visit the logout page
    Given specialist with email "deleted-session@example.com" and password "secret" is created
    When I submit the admin login form with email "deleted-session@example.com" and password "secret"
    And I confirm admin login with the latest authentication code for "deleted-session@example.com"
    And admin account "deleted-session@example.com" is soft deleted directly
    When I visit "/admin/faq"
    Then I should be on the admin login page

  Scenario: Soft deleted account is not accessible by direct URL
    When I create an admin account with email "hidden@example.com" first name "Ana" last name "Anaitė" role "specialist" and two-factor "enabled"
    And a password reset token was issued for admin "hidden@example.com"
    And I remember the account id for "hidden@example.com"
    And I delete admin account "hidden@example.com"
    When I visit the admin account detail page for the remembered account id
    Then the response status code should be 404

  Scenario: Soft deleted account can be recreated with the same email
    When I create an admin account with email "reusable@example.com" first name "Ana" last name "Anaitė" role "specialist" and two-factor "enabled"
    And I delete admin account "reusable@example.com"
    Then I should not see account "reusable@example.com" in the accounts list
    And admin account "reusable@example.com" should be soft deleted
    When I create an admin account with email "reusable@example.com" first name "Ana" last name "Anaitė" role "specialist" and two-factor "enabled"
    Then I should see account "reusable@example.com" in the accounts list

  Scenario: System administrator can resend an expired account invitation
    When I create an admin account with email "expired-resend@example.com" first name "Tomas" last name "Tomaitis" role "specialist" and two-factor "enabled"
    And admin "expired-resend@example.com" has an expired account invitation
    And I remember the invitation token hash for admin "expired-resend@example.com"
    When I resend the account invitation for "expired-resend@example.com"
    Then I should see "Pakvietimas išsiųstas iš naujo."
    And admin "expired-resend@example.com" should have a renewed invitation

  Scenario: Changing a pending account email renews its invitation
    When I create an admin account with email "old-invite@example.com" first name "Tomas" last name "Tomaitis" role "specialist" and two-factor "enabled"
    And I remember the invitation token hash for admin "old-invite@example.com"
    When I edit admin account "old-invite@example.com" setting email to "new-invite@example.com" and active to "active"
    Then admin "new-invite@example.com" should have a renewed invitation

  Scenario: Resending an invitation requires a valid CSRF token
    When I create an admin account with email "csrf@example.com" first name "Tomas" last name "Tomaitis" role "specialist" and two-factor "enabled"
    And I resend the account invitation for "csrf@example.com" without a valid CSRF token
    Then the response status code should be 403

  Scenario: Invitation password must satisfy password policy
    When I visit the logout page
    And specialist with email "weak-password@example.com" and password "secret" is created
    And admin "weak-password@example.com" has a pending account invitation
    When I set the account invitation password to "weak"
    Then I should see "Slaptažodis turi būti bent 12 simbolių."
    And an invitation should exist for admin "weak-password@example.com"

  Scenario: Invitation password setup redirects to two-factor login
    When I visit the logout page
    And specialist with email "activate@example.com" and password "secret" is created
    And admin "activate@example.com" has a pending account invitation
    When I set the account invitation password to "Newsecretpass1!"
    Then I should be on the admin two-factor login page
    When I cancel admin two-factor authentication
    And I open the account invitation link
    Then I should see "Paskyros aktyvavimo nuoroda negalioja arba pasibaigė."

  Scenario: Invitation setup without two-factor logs in securely
    When I visit the logout page
    And specialist with email "activate-no-2fa@example.com" and password "secret" is created
    And admin account "activate-no-2fa@example.com" has two-factor disabled directly
    And admin "activate-no-2fa@example.com" has a pending account invitation
    When I open the account invitation link
    And I remember the current session id
    And I set the account invitation password to "Newsecretpass1!"
    Then I should be on the admin FAQ page
    And the session id should have changed
    And admin "activate-no-2fa@example.com" should have a last active time
    And no invitation should exist for admin "activate-no-2fa@example.com"

  Scenario: Expired invitation token is rejected
    When I visit the logout page
    And specialist with email "expired-invitation@example.com" and password "secret" is created
    And admin "expired-invitation@example.com" has an expired account invitation
    When I open the account invitation link
    Then I should see "Paskyros aktyvavimo nuoroda negalioja arba pasibaigė."

  Scenario: Non system administrator cannot access accounts page
    Given specialist with email "specialist@example.com" and password "secret" is created
    When I visit the logout page
    And I submit the admin login form with email "specialist@example.com" and password "secret"
    And I confirm admin login with the latest authentication code for "specialist@example.com"
    And I visit the admin accounts list page
    Then the response status code should be 403
