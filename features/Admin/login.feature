Feature: Admin login

  Scenario: Login page shows required elements
    Given I visit "/admin/login"
    And I should see "Skundų priėmimo ir nagrinėjimo informacinė sistema"
    And I should see "El. paštas"
    And I should see "Slaptažodis"
    And I should see "Pamiršau slaptažodį"
    And I should see "Prisijungti"

  Scenario: Invalid credentials show error without two-factor step
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "wrong"
    And I should see "Neteisingi prisijungimo duomenys."
    And I should not see "Autentifikacijos kodas"

  Scenario: Empty credentials show error
    Given I submit the admin login form with email "" and password ""
    And I should see "Neteisingi prisijungimo duomenys."
    And I should not see "Autentifikacijos kodas"

  Scenario: Successful login requires two-factor authentication
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    And I should see "Autentifikacijos kodas"
    And I should see "Atšaukti"
    And I should see "Patvirtinti"
    And I should see "Negavote kodo?"
    And I should see "Siųsti kodą iš naujo"

  Scenario: Login email is case-insensitive
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "ADMIN@EXAMPLE.COM" and password "secret"
    And I should see "Autentifikacijos kodas"

  Scenario: Successful two-factor authentication logs in to admin
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    Given entity manager is cleared
    Given I confirm admin login with the latest authentication code for "admin@example.com"
    Given I should be on the admin accounts page
    And I should see "Paskyros"

  Scenario: Invalid authentication code shows error
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    Given I confirm admin login with authentication code "000000"
    And I should see "Neteisingas autentifikacijos kodas."

  Scenario: Empty authentication code shows error
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    Given I confirm admin login with authentication code " "
    And I should see "Įveskite autentifikacijos kodą."

  Scenario: Expired authentication code shows the expired code error
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    Given entity manager is cleared
    Given the authentication code for admin "admin@example.com" has expired
    Given I confirm admin login with the latest authentication code for "admin@example.com"
    And I should see "Autentifikacijos kodo galiojimo laikas pasibaigė. Siųskite kodą iš naujo."

  Scenario: Expired authentication code with invalid code shows invalid code error
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    Given entity manager is cleared
    Given the authentication code for admin "admin@example.com" has expired
    Given I confirm admin login with authentication code "000000"
    And I should see "Neteisingas autentifikacijos kodas."
    And I should not see "Autentifikacijos kodo galiojimo laikas pasibaigė. Siųskite kodą iš naujo."

  Scenario: After expired code error, entering wrong code shows invalid code error
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    Given entity manager is cleared
    Given the authentication code for admin "admin@example.com" has expired
    Given I confirm admin login with the latest authentication code for "admin@example.com"
    And I should see "Autentifikacijos kodo galiojimo laikas pasibaigė. Siųskite kodą iš naujo."
    Given I confirm admin login with authentication code "000000"
    And I should see "Neteisingas autentifikacijos kodas."

  Scenario: Cancel two-factor authentication returns to login
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    Given I cancel admin two-factor authentication
    Given I should be on the admin login page
    And I should see "Prisijungti"

  Scenario: Resend authentication code shows confirmation
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    Given I resend the admin authentication code
    And I should see "Jums buvo išsiųstas naujas patvirtinimo kodas."

  Scenario: Forgot password form does not show login errors
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "wrong"
    Given I open the admin forgot password form
    And I should not see "Neteisingi prisijungimo duomenys."

  Scenario: Forgot password shows email field and reset button
    Given I open the admin forgot password form
    And I should see "El. paštas"
    And I should see "Atkurti slaptažodį"

  Scenario: Forgot password shows generic confirmation message
    Given admin with email "admin@example.com" and password "secret" is created
    Given I request admin password reset for email "admin@example.com"
    And I should see "Jei nurodytas el. pašto adresas yra registruotas mūsų sistemoje, netrukus gausite laišką su nuoroda slaptažodžiui atkurti."
    And I should see "Jei slaptažodžio atkūrimo užklausą jau pateikėte, naują užklausą galėsite pateikti po 5 minučių."
    And the response should contain "alert alert-info"

  Scenario: Forgot password for unknown email shows the same confirmation message
    Given I request admin password reset for email "unknown@example.com"
    And I should see "Jei nurodytas el. pašto adresas yra registruotas mūsų sistemoje, netrukus gausite laišką su nuoroda slaptažodžiui atkurti."
    And I should see "Jei slaptažodžio atkūrimo užklausą jau pateikėte, naują užklausą galėsite pateikti po 5 minučių."

  Scenario: Repeating password reset request within throttle period shows confirmation message
    Given admin with email "admin@example.com" and password "secret" is created
    Given a password reset token was issued for admin "admin@example.com"
    Given I request admin password reset for email "admin@example.com"
    And I should see "Jei slaptažodžio atkūrimo užklausą jau pateikėte, naują užklausą galėsite pateikti po 5 minučių."

  Scenario: Repeating password reset request within throttle period keeps the previous link valid
    Given admin with email "admin@example.com" and password "secret" is created
    Given a password reset token was issued for admin "admin@example.com"
    Given I request admin password reset for email "admin@example.com"
    Given I visit the remembered password reset link
    And I should not see "Slaptažodžio atkūrimo nuoroda negalioja."

  Scenario: Repeating password reset request after throttle invalidates the previous link
    Given admin with email "admin@example.com" and password "secret" is created
    Given a password reset token was issued for admin "admin@example.com"
    Given the password reset throttle has passed for admin "admin@example.com"
    Given I request admin password reset for email "admin@example.com"
    Given I visit the remembered password reset link
    And I should see "Slaptažodžio atkūrimo nuoroda negalioja."
    Given admin "admin@example.com" should have exactly 1 password reset request

  Scenario: Password reset allows login with new password
    Given admin with email "admin@example.com" and password "secret" is created
    Given a password reset token was issued for admin "admin@example.com"
    Given I reset admin password using the stored reset token to "Newsecretpass1!"
    Given I submit the admin login form with email "admin@example.com" and password "Newsecretpass1!"
    Given entity manager is cleared
    Given I confirm admin login with the latest authentication code for "admin@example.com"
    Given I should be on the admin accounts page

  Scenario: Password reset rejects the current password
    Given admin with email "same-password@example.com" and password "Newsecretpass1!" is created
    Given a password reset token was issued for admin "same-password@example.com"
    Given I reset admin password using the stored reset token to "Newsecretpass1!"
    And I should see "Naujas slaptažodis negali sutapti su šiuo metu naudojamu slaptažodžiu."
    Given I reset admin password using the stored reset token to "Differentpass1!"
    Given I submit the admin login form with email "same-password@example.com" and password "Differentpass1!"
    Given entity manager is cleared
    Given I confirm admin login with the latest authentication code for "same-password@example.com"
    Given I should be on the admin accounts page

  Scenario: Resend authentication code invalidates the previous code
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    Given entity manager is cleared
    Given I remember the current authentication code for "admin@example.com"
    Given I resend the admin authentication code
    Given I confirm admin login with the remembered authentication code
    And I should see "Neteisingas autentifikacijos kodas."

  Scenario: Inactive admin cannot log in
    Given inactive admin with email "inactive@example.com" and password "secret" is created
    Given I submit the admin login form with email "inactive@example.com" and password "secret"
    And I should see "Jūsų paskyra yra deaktyvuota. Dėl prieigos kreipkitės į sistemos administratorių."
    And I should not see "Autentifikacijos kodas"

  Scenario: Admin can log out
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    Given entity manager is cleared
    Given I confirm admin login with the latest authentication code for "admin@example.com"
    Given I visit the logout page
    Given I should be on the admin login page
