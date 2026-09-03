Feature: Private stored files

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    When I submit the admin login form with email "admin@example.com" and password "secret"
    And entity manager is cleared
    And I confirm admin login with the latest authentication code for "admin@example.com"

  Scenario: Admin can download a private stored file
    Given stored files are loaded:
      | originalName | content              | uploadedByAdmin   |
      | document.txt | private file content | admin@example.com |
    When I download stored file "document.txt" by original name
    Then the response status code should be 200
    And the downloaded stored file content should be "private file content"
    And the downloaded stored file should be an attachment named "document.txt"

  Scenario: File download requires an authenticated admin session
    Given stored files are loaded:
      | originalName | content    | uploadedByAdmin   |
      | private.txt  | owner only | admin@example.com |
    When the admin session is cleared
    And I download stored file "private.txt" by original name
    Then the file download should redirect to admin login

  Scenario: Missing file metadata returns not found
    When I download stored file "01980fc0-0000-7000-8000-000000000000"
    Then the response status code should be 404

  Scenario: Missing S3 object returns not found
    Given file metadata without an S3 object exists for admin "admin@example.com"
    And I download the stored file
    Then the response status code should be 404

  Scenario: Department head can download own private stored file
    When I visit the logout page
    Given department_head with email "head@example.com" and password "secret" is created without two-factor
    And stored files are loaded:
      | originalName  | content      | uploadedByAdmin   |
      | head-only.txt | head private | head@example.com  |
    When I submit the admin login form with email "head@example.com" and password "secret"
    And I download stored file "head-only.txt" by original name
    Then the response status code should be 200

  Scenario: Department head cannot download system administrator private stored file
    When I visit the logout page
    Given department_head with email "head@example.com" and password "secret" is created without two-factor
    And stored files are loaded:
      | originalName   | content       | uploadedByAdmin    |
      | admin-only.txt | admin private | admin@example.com  |
    When I submit the admin login form with email "head@example.com" and password "secret"
    And I download stored file "admin-only.txt" by original name
    Then the response status code should be 403

  Scenario: System administrator cannot download department head private stored file
    Given department_head with email "head@example.com" and password "secret" is created without two-factor
    And stored files are loaded:
      | originalName     | content         | uploadedByAdmin   |
      | head-private.txt | not for sysadmin | head@example.com |
    When I download stored file "head-private.txt" by original name
    Then the response status code should be 403

  Scenario: Complaint attachment uploader can download their file
    Given a full complaint exists with number "SK-2026-UPLOADER-01"
    And stored file "patient-id.pdf" uploaded by "jonas.jonaitis@example.com" is registered for download
    When I visit the logout page
    And I submit the admin login form with email "jonas.jonaitis@example.com" and password "secret"
    And I download stored file "patient-id.pdf" by original name
    Then the response status code should be 200
