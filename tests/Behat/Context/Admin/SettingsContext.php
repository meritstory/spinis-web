<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use App\Entity\Setting;
use App\Repository\SettingRepository;
use App\Service\Request\RequestMailer;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class SettingsContext extends RawMinkContext implements Context
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SettingRepository $settingRepository,
        private readonly RequestMailer $requestMailer,
    ) {
    }

    #[Given('a setting exists with key :key and value :value')]
    public function aSettingExists(string $key, string $value): void
    {
        $setting = new Setting()
            ->setKey($key)
            ->setValue($value);

        $this->entityManager->persist($setting);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    #[Given('I open the admin create setting form')]
    public function iOpenTheAdminCreateSettingForm(): void
    {
        $this->getClient()->request('GET', '/admin/setting/new');
    }

    #[Given('I submit the admin setting form without data')]
    public function iSubmitTheAdminSettingFormWithoutData(): void
    {
        $this->submitSettingForm('', '');
    }

    #[Given('I submit the admin setting form with key :key and value :value')]
    public function iSubmitTheAdminSettingFormWithData(string $key, string $value): void
    {
        $this->submitSettingForm($key, $value);
    }

    #[Given('the admin settings list is open')]
    public function theAdminSettingsListIsOpen(): void
    {
        $this->assertLastResponseStatus(Response::HTTP_OK);
        $this->assertSession()->addressMatches('#/admin/setting($|\\?)#');
        $this->assertSession()->pageTextContains('Nustatymai');
    }

    #[Given('a setting with key :key and value :value should exist in the database')]
    public function aSettingWithKeyAndValueShouldExistInTheDatabase(string $key, string $value): void
    {
        $this->entityManager->clear();

        $setting = $this->settingRepository->findOneBy(['key' => $key]);
        Assert::notNull($setting);
        Assert::same($value, $setting->getValue());
    }

    #[Given('the admin setting form has required field validation errors')]
    public function theAdminSettingFormHasRequiredFieldValidationErrors(): void
    {
        $this->assertUnprocessableFormResponse();
        $this->assertSession()->pageTextContains('Pasirinkite nustatymą.');
        $this->assertSession()->pageTextContains('Įveskite reikšmę.');
    }

    #[Given('the admin setting form has an invalid email validation error')]
    public function theAdminSettingFormHasAnInvalidEmailValidationError(): void
    {
        $this->assertUnprocessableFormResponse();
        $this->assertSession()->pageTextContains('Įveskite galiojantį el. pašto adresą.');
    }

    #[Given('the admin create setting form should not show key :label')]
    public function theAdminCreateSettingFormShouldNotShowKey(string $label): void
    {
        $this->assertLastResponseStatus(Response::HTTP_OK);
        $this->assertSession()->addressMatches('#/admin/setting/new#');

        $options = $this->getClient()->getCrawler()->filter('select option');
        $labels = [];

        foreach ($options as $option) {
            $labels[] = trim($option->textContent ?? '');
        }

        Assert::false(in_array($label, $labels, true));
    }

    #[Given('the request recipient email should be :email')]
    public function theRequestRecipientEmailShouldBe(string $email): void
    {
        Assert::same($email, $this->requestMailer->getRecipientEmail());
    }

    private function submitSettingForm(string $key, string $value): void
    {
        $client = $this->getClient();
        $client->request('GET', '/admin/setting/new');
        $crawler = $client->getCrawler();
        $formNode = $crawler->filter('form.ea-new-form');
        Assert::greaterThan($formNode->count(), 0, 'Setting create form was not found on the page.');

        $form = $formNode->form();
        $token = $form['Setting[_token]']->getValue();

        $client->request('POST', '/admin/setting/new', [
            'Setting' => [
                'key' => $key,
                'value' => $value,
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
        $this->assertLastResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertSession()->addressMatches('#/admin/setting/new#');
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
