<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use App\Entity\Link;
use App\Repository\LinkRepository;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class LinkContext extends RawMinkContext implements Context
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LinkRepository $linkRepository,
    ) {
    }

    #[Given('a link exists with title :title, key :key and url :url')]
    public function aLinkExists(string $title, string $key, string $url): void
    {
        $link = new Link()
            ->setTitle($title)
            ->setKey($key)
            ->setUrl($url);

        $this->entityManager->persist($link);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    #[Given('I open the admin links section from the menu')]
    public function iOpenTheAdminLinksSectionFromTheMenu(): void
    {
        $client = $this->getClient();

        if (!str_contains($client->getRequest()->getPathInfo(), '/admin')) {
            $client->request('GET', '/admin/admin');
        }

        $client->click($client->getCrawler()->selectLink('Nuorodos')->link());
    }

    #[Given('I open the admin create link form')]
    public function iOpenTheAdminCreateLinkForm(): void
    {
        $this->getClient()->request('GET', '/admin/link/new');
    }

    #[Given('I submit the admin link form without data')]
    public function iSubmitTheAdminLinkFormWithoutData(): void
    {
        $this->submitLinkForm('', '', '');
    }

    #[Given('I submit the admin link form with title :title, key :key and url :url')]
    public function iSubmitTheAdminLinkFormWithData(string $title, string $key, string $url): void
    {
        $this->submitLinkForm($title, $key, $url);
    }

    #[Given('the admin links list is open')]
    public function theAdminLinksListIsOpen(): void
    {
        $this->assertLastResponseStatus(Response::HTTP_OK);
        $this->assertSession()->addressMatches('#/admin/link($|\\?)#');
        $this->assertSession()->pageTextContains('Nuorodos');
        $this->assertSession()->pageTextContains('Sukurti nuorodą');
    }

    #[Given('a link with key :key, title :title and url :url should exist in the database')]
    public function aLinkWithKeyTitleAndUrlShouldExistInTheDatabase(string $key, string $title, string $url): void
    {
        $this->entityManager->clear();

        $link = $this->linkRepository->findOneBy(['key' => $key]);
        Assert::notNull($link);
        Assert::same($title, $link->getTitle());
        Assert::same($url, $link->getUrl());
    }

    #[Given('the admin link form has required field validation errors')]
    public function theAdminLinkFormHasRequiredFieldValidationErrors(): void
    {
        $this->assertUnprocessableFormResponse();
        $this->assertSession()->pageTextContains('Įveskite pavadinimą.');
        $this->assertSession()->pageTextContains('Įveskite raktą.');
        $this->assertSession()->pageTextContains('Įveskite nuorodą.');
    }

    #[Given('the admin link form has an invalid url validation error')]
    public function theAdminLinkFormHasAnInvalidUrlValidationError(): void
    {
        $this->assertUnprocessableFormResponse();
        $this->assertSession()->pageTextContains('Įveskite galiojančią nuorodą.');
    }

    #[Given('the admin link form has a duplicate key validation error')]
    public function theAdminLinkFormHasADuplicateKeyValidationError(): void
    {
        $this->assertUnprocessableFormResponse();
        $this->assertSession()->pageTextContains('Toks raktas jau egzistuoja.');
    }

    private function submitLinkForm(string $title, string $key, string $url): void
    {
        $client = $this->getClient();
        $form = $client->getCrawler()->selectButton('saveAndReturn')->form();
        $form['Link[title]'] = $title;
        $form['Link[key]'] = $key;
        $form['Link[url]'] = $url;
        $client->submit($form);
    }

    private function assertUnprocessableFormResponse(): void
    {
        $this->assertLastResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertSession()->addressMatches('#/admin/link/new#');
    }

    private function assertLastResponseStatus(int $expected): void
    {
        Assert::same($expected, $this->getClient()->getResponse()->getStatusCode());
    }

    private function getClient(): KernelBrowser
    {
        $client = $this->getSession()->getDriver()->getClient();
        Assert::isInstanceOf($client, KernelBrowser::class);

        return $client;
    }
}
