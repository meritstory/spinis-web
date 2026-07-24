<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use App\Entity\Setting;
use App\Repository\SettingRepository;
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
        $this->createSettingWithKey('');
    }

    #[Given('I create a setting with key :key')]
    public function iCreateASettingWithKey(string $key): void
    {
        $this->createSettingWithKey($key);
    }

    #[Given('I submit the admin setting value :value')]
    public function iSubmitTheAdminSettingValue(string $value): void
    {
        $client = $this->getClient();
        $formNode = $client->getCrawler()->filter('form.ea-edit-form');
        Assert::greaterThan($formNode->count(), 0, 'Setting edit form was not found on the page.');

        $form = $formNode->form();
        $token = $form['Setting[_token]']->getValue();

        $client->request('POST', $form->getUri(), [
            'Setting' => [
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

    #[Given('the admin setting form has a key validation error')]
    public function theAdminSettingFormHasAKeyValidationError(): void
    {
        $this->assertUnprocessableFormResponse();
        $this->assertSession()->pageTextContains('Pasirinkite nustatymą.');
    }

    #[Given('the admin setting form has an invalid date validation error')]
    public function theAdminSettingFormHasAnInvalidDateValidationError(): void
    {
        $this->assertLastResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertSession()->pageTextContains('Įveskite teisingą datą.');
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

    private function createSettingWithKey(string $key): void
    {
        $client = $this->getClient();
        $client->request('GET', '/admin/setting/new');
        $formNode = $client->getCrawler()->filter('form.ea-new-form');
        Assert::greaterThan($formNode->count(), 0, 'Setting create form was not found on the page.');

        $form = $formNode->form();
        $token = $form['Setting[_token]']->getValue();

        $client->request('POST', '/admin/setting/new', [
            'Setting' => [
                'key' => $key,
                '_token' => $token,
            ],
            'ea' => [
                'newForm' => [
                    'btn' => 'saveAndContinue',
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
