Feature: Admin login

  Scenario: Login page shows required elements
    When I visit "/admin/login"
    Then I should see "Skundų priėmimo ir nagrinėjimo informacinė sistema"
    And I should see "El. paštas"
    And I should see "Slaptažodis"
    And I should see "Pamiršau slaptažodį"
    And I should see "Prisijungti"

  Scenario: Invalid credentials show error without two-factor step
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "wrong"
    Then I should see "Neteisingi prisijungimo duomenys."
    And I should not see "Autentifikacijos kodas"

  Scenario: Successful login requires two-factor authentication
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    Then I should see "Autentifikacijos kodas"
    And I should see "Atšaukti"
    And I should see "Patvirtinti"
    And I should see "Negavote kodo?"
    And I should see "Siųsti kodą iš naujo"

  Scenario: Login email is case-insensitive
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "ADMIN@EXAMPLE.COM" and password "secret"
    Then I should see "Autentifikacijos kodas"

  Scenario: Successful two-factor authentication logs in to admin
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And I confirm admin login with the latest authentication code for "admin@example.com"
    Then I should be on the admin accounts page
    And I should see "Paskyros"

  Scenario: Invalid authentication code shows error
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And I confirm admin login with authentication code "000000"
    Then I should see "Neteisingas autentifikacijos kodas."

  Scenario: Empty authentication code shows error
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And I confirm admin login with authentication code " "
    Then I should see "Įveskite autentifikacijos kodą."

  Scenario: Expired authentication code shows error
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And the authentication code for admin "admin@example.com" has expired
    And I confirm admin login with the latest authentication code for "admin@example.com"
    Then I should see "Autentifikacijos kodo galiojimo laikas pasibaigė. Siųskite kodą iš naujo."

  Scenario: Cancel two-factor authentication returns to login
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And I cancel admin two-factor authentication
    Then I should be on the admin login page
    And I should see "Prisijungti"

  Scenario: Resend authentication code shows confirmation
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And I resend the admin authentication code
    Then I should see "Jums buvo išsiųstas naujas patvirtinimo kodas."

  Scenario: Forgot password shows email field and reset button
    When I open the admin forgot password form
    Then I should see "El. paštas"
    And I should see "Atkurti slaptažodį"

  Scenario: Forgot password shows generic confirmation message
    Given admin with email "admin@example.com" and password "secret" is created
    When I request admin password reset for email "admin@example.com"
    Then I should see "Jei nurodytas el. pašto adresas yra registruotas mūsų sistemoje, netrukus gausite laišką su nuoroda slaptažodžiui atkurti"

  Scenario: Forgot password for unknown email shows the same confirmation message
    When I request admin password reset for email "unknown@example.com"
    Then I should see "Jei nurodytas el. pašto adresas yra registruotas mūsų sistemoje, netrukus gausite laišką su nuoroda slaptažodžiui atkurti"

  Scenario: Password reset allows login with new password
    Given admin with email "admin@example.com" and password "secret" is created
    And a password reset token was issued for admin "admin@example.com"
    When I reset admin password using the stored reset token to "Newsecretpass1!"
    And I submit the admin login form with email "admin@example.com" and password "Newsecretpass1!"
    And I confirm admin login with the latest authentication code for "admin@example.com"
    Then I should be on the admin accounts page

  Scenario: Resend authentication code invalidates the previous code
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And I remember the current authentication code for "admin@example.com"
    And I resend the admin authentication code
    And I confirm admin login with the remembered authentication code
    Then I should see "Neteisingas autentifikacijos kodas."

  Scenario: Inactive admin cannot log in
    Given inactive admin with email "inactive@example.com" and password "secret" is created
    When I submit the admin login form with email "inactive@example.com" and password "secret"
    Then I should see "Neteisingi prisijungimo duomenys."
    And I should not see "Autentifikacijos kodas"

  Scenario: Admin can log out
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And I confirm admin login with the latest authentication code for "admin@example.com"
    When I visit the logout page
    Then I should be on the admin login page
