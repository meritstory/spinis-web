Feature: Private stored files

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    And I am logged in to the admin panel as "admin@example.com" with password "secret"

  Scenario: Admin can download a private stored file
    Given stored file "document.txt" with content "private file content" exists for admin "admin@example.com"
    When I download the stored file
    Then the response status code should be 200
    And the downloaded stored file content should be "private file content"
    And the downloaded stored file should be an attachment named "document.txt"

  Scenario: File download requires an authenticated admin session
    Given stored file "private.txt" with content "owner only" exists for admin "admin@example.com"
    And the admin session is cleared
    When I download the stored file
    Then the file download should redirect to admin login

  Scenario: Missing file metadata returns not found
    When I download stored file "01980fc0-0000-7000-8000-000000000000"
    Then the response status code should be 404

  Scenario: Missing S3 object returns not found
    Given file metadata without an S3 object exists for admin "admin@example.com"
    When I download the stored file
    Then the response status code should be 404

  Scenario: Department head can download own private stored file
    When I visit the logout page
    Given department_head with email "head@example.com" and password "secret" is created without two-factor
    And stored file "head-only.txt" with content "head private" exists for admin "head@example.com"
    And I am logged in to the admin panel as "head@example.com" with password "secret" without two-factor
    When I download stored file "head-only.txt" uploaded by admin "head@example.com"
    Then the response status code should be 200

  Scenario: Department head cannot download system administrator private stored file
    When I visit the logout page
    Given department_head with email "head@example.com" and password "secret" is created without two-factor
    And stored file "admin-only.txt" with content "admin private" exists for admin "admin@example.com"
    And I am logged in to the admin panel as "head@example.com" with password "secret" without two-factor
    When I download stored file "admin-only.txt" uploaded by admin "admin@example.com"
    Then the response status code should be 403

  Scenario: System administrator cannot download department head private stored file
    Given department_head with email "head@example.com" and password "secret" is created without two-factor
    And stored file "head-private.txt" with content "not for sysadmin" exists for admin "head@example.com"
    When I download stored file "head-private.txt" uploaded by admin "head@example.com"
    Then the response status code should be 403

  Scenario: Complaint attachment uploader can download their file
    Given a full complaint exists with number "SK-2026-UPLOADER-01"
    And I visit the logout page
    And I am logged in to the admin panel as "jonas.jonaitis@example.com" with password "secret" without two-factor
    When I download stored file "patient-id.pdf" uploaded by admin "jonas.jonaitis@example.com"
    Then the response status code should be 200
