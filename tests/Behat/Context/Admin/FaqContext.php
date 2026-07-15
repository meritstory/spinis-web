<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Behat\Step\Then;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Webmozart\Assert\Assert;

final class FaqContext extends RawMinkContext implements Context
{
    #[Given('I visit the admin FAQ create page')]
    public function iVisitTheAdminFaqCreatePage(): void
    {
        $this->getClient()->request('GET', '/admin/faq/new');
    }

    #[Given('I visit the admin FAQ list page')]
    public function iVisitTheAdminFaqListPage(): void
    {
        $this->getClient()->request('GET', '/admin/faq');
    }

    #[Given('I submit the FAQ form with question :question answer :answer position :position')]
    public function iSubmitTheFaqForm(string $question, string $answer, string $position): void
    {
        $client = $this->getClient();
        $client->request('GET', '/admin/faq/new');
        $crawler = $client->getCrawler();
        $formNode = $crawler->filter('form.ea-new-form');
        Assert::greaterThan($formNode->count(), 0, 'FAQ create form was not found on the page.');

        $form = $formNode->form();
        $token = $form['Faq[_token]']->getValue();

        $client->request('POST', '/admin/faq/new', [
            'Faq' => [
                'question' => $question,
                'answer' => $answer,
                'position' => $position,
                '_token' => $token,
            ],
            'ea' => [
                'newForm' => [
                    'btn' => 'saveAndReturn',
                ],
            ],
        ]);
    }

    #[Then('I should be on the admin FAQ list page')]
    public function iShouldBeOnTheAdminFaqListPage(): void
    {
        $this->assertSession()->addressMatches('#/admin/faq(?:\?.*)?$#');
    }

    #[Then('I should be on the admin FAQ create page')]
    public function iShouldBeOnTheAdminFaqCreatePage(): void
    {
        $this->assertSession()->addressMatches('#/admin/faq/new#');
    }

    private function getClient(): KernelBrowser
    {
        $client = $this->getSession()->getDriver()->getClient();
        Assert::isInstanceOf($client, KernelBrowser::class);

        return $client;
    }
}
