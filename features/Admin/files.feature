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
