Feature: Private stored files

  Background:
    Given admin with email "admin@example.com" and password "secret" is created
    Given I submit the admin login form with email "admin@example.com" and password "secret"
    And entity manager is cleared
    And I confirm admin login with the latest authentication code for "admin@example.com"

  Scenario: Admin can download a private stored file
    Given stored files are loaded:
      | originalName | content              | uploadedByAdmin   |
      | document.txt | private file content | admin@example.com |
    Given I download stored file "document.txt" by original name
    And the response status code should be 200
    Given the downloaded stored file content should be "private file content"
    Given the downloaded stored file should be an attachment named "document.txt"

  Scenario: File download requires an authenticated admin session
    Given stored files are loaded:
      | originalName | content    | uploadedByAdmin   |
      | private.txt  | owner only | admin@example.com |
    Given the admin session is cleared
    Given I download stored file "private.txt" by original name
    Given the file download should redirect to admin login

  Scenario: Missing file metadata returns not found
    Given I download stored file "01980fc0-0000-7000-8000-000000000000"
    And the response status code should be 404

  Scenario: Missing S3 object returns not found
    Given file metadata without an S3 object exists for admin "admin@example.com"
    Given I download the stored file
    And the response status code should be 404

  Scenario: Department head can download own private stored file
    Given I visit the logout page
    Given department_head with email "head@example.com" and password "secret" is created without two-factor
    Given stored files are loaded:
      | originalName  | content      | uploadedByAdmin   |
      | head-only.txt | head private | head@example.com  |
    Given I submit the admin login form with email "head@example.com" and password "secret"
    Given I download stored file "head-only.txt" by original name
    And the response status code should be 200

  Scenario: Department head cannot download system administrator private stored file
    Given I visit the logout page
    Given department_head with email "head@example.com" and password "secret" is created without two-factor
    Given stored files are loaded:
      | originalName   | content       | uploadedByAdmin    |
      | admin-only.txt | admin private | admin@example.com  |
    Given I submit the admin login form with email "head@example.com" and password "secret"
    Given I download stored file "admin-only.txt" by original name
    And the response status code should be 403

  Scenario: System administrator cannot download department head private stored file
    Given department_head with email "head@example.com" and password "secret" is created without two-factor
    Given stored files are loaded:
      | originalName     | content         | uploadedByAdmin   |
      | head-private.txt | not for sysadmin | head@example.com |
    Given I download stored file "head-private.txt" by original name
    And the response status code should be 403

  Scenario: Complaint attachment uploader can download their file
    Given a full complaint exists with number "SK-2026-UPLOADER-01"
    Given I visit the logout page
    Given I submit the admin login form with email "jonas.jonaitis@example.com" and password "secret"
    Given I download stored file "patient-id.pdf" by original name
    And the response status code should be 200
