<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use App\Entity\Document;
use App\Repository\DocumentRepository;
use App\Tests\Behat\Context\FeatureContext;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class DocumentContext extends RawMinkContext implements Context
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly DocumentRepository $documentRepository,
    ) {
    }

    #[Given('/^documents are loaded:$/')]
    public function documentsAreLoaded(TableNode $table): void
    {
        $propertyAccessor = FeatureContext::getPropertyAccessor();

        foreach ($table as $row) {
            $document = new Document();

            foreach ($row as $property => $value) {
                $propertyAccessor->setValue(
                    $document,
                    $property,
                    'updatedAt' === $property ? new \DateTime($value) : $value,
                );
            }

            $this->entityManager->persist($document);
        }

        $this->entityManager->flush();
    }

    #[Given('I open the admin create document form')]
    public function iOpenTheAdminCreateDocumentForm(): void
    {
        $this->getClient()->request('GET', '/admin/document/new');
    }

    #[Given('I submit the admin document form without data')]
    public function iSubmitTheAdminDocumentFormWithoutData(): void
    {
        $this->submitDocumentForm('', '', '');
    }

    #[Given('the admin document form has required field validation errors')]
    public function theAdminDocumentFormHasRequiredFieldValidationErrors(): void
    {
        $this->assertUnprocessableFormResponse();
        $this->assertSession()->pageTextContains('Įveskite pavadinimą.');
        $this->assertSession()->pageTextContains('Pasirinkite raktą.');
        $this->assertSession()->pageTextContains('Įveskite aprašymą.');
    }

    #[Given('I submit the admin document form with title :title key :key and description :description')]
    public function iSubmitTheAdminDocumentFormWithData(string $title, string $key, string $description): void
    {
        $this->submitDocumentForm($title, $key, $description);
    }

    #[Given('the admin documents list is open')]
    public function theAdminDocumentsListIsOpen(): void
    {
        Assert::same(Response::HTTP_OK, $this->getClient()->getResponse()->getStatusCode());
        $this->assertSession()->addressMatches('#/admin/document($|\\?)#');
        $this->assertSession()->pageTextContains('Dokumentai');
    }

    #[Given('a document with key :key and title :title should exist in the database')]
    public function aDocumentWithKeyAndTitleShouldExistInTheDatabase(string $key, string $title): void
    {
        $document = $this->documentRepository->findOneBy(['key' => $key]);
        Assert::notNull($document);
        Assert::same($title, $document->getTitle());
    }

    #[Given('the admin create document form should not show key :label')]
    public function theAdminCreateDocumentFormShouldNotShowKey(string $label): void
    {
        Assert::same(Response::HTTP_OK, $this->getClient()->getResponse()->getStatusCode());
        $this->assertSession()->addressMatches('#/admin/document/new#');

        $options = $this->getClient()->getCrawler()->filter('select option');
        $labels = [];

        foreach ($options as $option) {
            $labels[] = trim($option->textContent ?? '');
        }

        Assert::false(in_array($label, $labels, true));
    }

    #[Given('I search the admin documents list for :query')]
    public function iSearchTheAdminDocumentsListFor(string $query): void
    {
        $this->getClient()->request('GET', '/admin/document', ['query' => $query]);
    }

    #[Given('the admin documents list shows :firstText and :secondText')]
    public function theAdminDocumentsListShowsTexts(string $firstText, string $secondText): void
    {
        $this->assertSession()->pageTextContains($firstText);
        $this->assertSession()->pageTextContains($secondText);
    }

    #[Given('the admin documents list shows :text')]
    public function theAdminDocumentsListShowsText(string $text): void
    {
        $this->assertSession()->pageTextContains($text);
    }

    #[Given('the admin create document form shows :text')]
    public function theAdminCreateDocumentFormShowsText(string $text): void
    {
        Assert::same(Response::HTTP_OK, $this->getClient()->getResponse()->getStatusCode());
        $this->assertSession()->addressMatches('#/admin/document/new#');
        $this->assertSession()->pageTextContains($text);
    }

    #[Given('I delete the document with key :key from the admin index')]
    public function iDeleteTheDocumentWithKeyFromTheAdminIndex(string $key): void
    {
        $document = $this->documentRepository->findOneBy(['key' => $key]);
        Assert::notNull($document);
        $documentId = $document->getId();
        Assert::notNull($documentId);

        $client = $this->getClient();
        $client->request('GET', '/admin/document');
        $crawler = $client->getCrawler();

        $token = $crawler->filter('#action-confirmation-form input[name="token"]')->attr('value');
        Assert::notNull($token);

        $client->request('POST', sprintf('/admin/document/%d/delete', $documentId), [
            'token' => $token,
        ]);
    }

    #[Given('a document with key :key should not exist in the database')]
    public function aDocumentWithKeyShouldNotExistInTheDatabase(string $key): void
    {
        Assert::null($this->documentRepository->findOneBy(['key' => $key]));
    }

    #[Given('I open the admin edit document form for key :key')]
    public function iOpenTheAdminEditDocumentFormForKey(string $key): void
    {
        $document = $this->documentRepository->findOneBy(['key' => $key]);
        Assert::notNull($document);
        Assert::notNull($document->getId());

        $this->getClient()->request('GET', sprintf('/admin/document/%d/edit', $document->getId()));
        Assert::same(Response::HTTP_OK, $this->getClient()->getResponse()->getStatusCode());
    }

    #[Given('the admin edit document form allows changing the key')]
    public function theAdminEditDocumentFormAllowsChangingTheKey(): void
    {
        $this->assertSession()->addressMatches('#/admin/document/\d+/edit#');

        $keyField = $this->getClient()->getCrawler()->filter('select[name="Document[key]"]');
        Assert::greaterThan($keyField->count(), 0, 'Document key select was not found on the edit form.');
        Assert::null($keyField->attr('disabled'));
    }

    #[Given('I submit the admin document edit form with key :key')]
    public function iSubmitTheAdminDocumentEditFormWithKey(string $key): void
    {
        $client = $this->getClient();
        $crawler = $client->getCrawler();
        $formNode = $crawler->filter('form.ea-edit-form');
        Assert::greaterThan($formNode->count(), 0, 'Document edit form was not found on the page.');

        $form = $formNode->form();
        $form['Document[key]']->setValue($key);

        $client->submit($form);
    }

    private function submitDocumentForm(string $title, string $key, string $description): void
    {
        $client = $this->getClient();
        $client->request('GET', '/admin/document/new');
        $crawler = $client->getCrawler();
        $formNode = $crawler->filter('form.ea-new-form');
        Assert::greaterThan($formNode->count(), 0, 'Document create form was not found on the page.');

        $form = $formNode->form();
        $token = $form['Document[_token]']->getValue();

        $client->request('POST', '/admin/document/new', [
            'Document' => [
                'title' => $title,
                'key' => $key,
                'description' => $description,
                '_token' => $token,
            ],
            'ea' => [
                'newForm' => [
                    'btn' => 'saveAndReturn',
                ],
            ],
        ]);
    }

    private function assertUnprocessableFormResponse(): void
    {
        Assert::same(Response::HTTP_UNPROCESSABLE_ENTITY, $this->getClient()->getResponse()->getStatusCode());
        $this->assertSession()->addressMatches('#/admin/document/new#');
    }

    private function getClient(): KernelBrowser
    {
        $client = $this->getSession()->getDriver()->getClient();
        Assert::isInstanceOf($client, KernelBrowser::class);

        return $client;
    }
}
