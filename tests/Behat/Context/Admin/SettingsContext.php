<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use App\Entity\Setting;
use App\Enum\SettingKeyEnum;
use App\Repository\SettingRepository;
use App\Service\Admin\LabelledEnumHelper;
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
        private readonly LabelledEnumHelper $labelledEnumHelper,
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
    }

    #[Given('settings exist for all setting keys')]
    public function settingsExistForAllSettingKeys(): void
    {
        $values = [
            SettingKeyEnum::REQUEST_RECIPIENT_EMAIL->value => 'requests@example.com',
            SettingKeyEnum::VERSION->value => '0.0.1',
            SettingKeyEnum::HEALTH_CARE_INSTITUTION_IMPORT_FROM->value => '2026-07-23T00:00:00+00:00',
        ];

        foreach ($values as $key => $value) {
            $this->aSettingExists($key, $value);
        }
    }

    #[Given('I open the admin create setting form')]
    public function iOpenTheAdminCreateSettingForm(): void
    {
        $this->getClient()->request('GET', '/admin/setting/new');
    }

    #[Given('I submit the admin setting form without data')]
    public function iSubmitTheAdminSettingFormWithoutData(): void
    {
        $this->iOpenTheAdminCreateSettingForm();
        $this->submitAdminSettingCreateForm('');
    }

    #[Given('I submit the admin setting form with key :key')]
    public function iSubmitTheAdminSettingFormWithKey(string $key): void
    {
        $this->submitAdminSettingCreateForm($key);
    }

    #[Given('I should be on the admin setting edit page for key :key')]
    public function iShouldBeOnTheAdminSettingEditPageForKey(string $key): void
    {
        $this->assertLastResponseStatus(Response::HTTP_OK);

        $setting = $this->settingRepository->findOneBy(['key' => $key]);
        Assert::notNull($setting);
        Assert::notNull($setting->getId());

        $this->assertSession()->addressMatches(sprintf('#/admin/setting/%d/edit#', $setting->getId()));
    }

    #[Given('I create a setting with key :key')]
    public function iCreateASettingWithKey(string $key): void
    {
        $this->iOpenTheAdminCreateSettingForm();
        $this->submitAdminSettingCreateForm($key);
    }

    #[Given('I submit the admin setting value :value and continue editing')]
    public function iSubmitTheAdminSettingValueAndContinueEditing(string $value): void
    {
        $this->submitAdminSettingValue($value, 'saveAndContinue');
    }

    #[Given('I submit the admin setting value :value')]
    public function iSubmitTheAdminSettingValue(string $value): void
    {
        $this->submitAdminSettingValue($value, 'saveAndReturn');
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
        $setting = $this->settingRepository->findOneBy(['key' => $key]);
        Assert::notNull($setting);
        Assert::same($value, $setting->getValue());
    }

    #[Given('a setting with key :key should not appear in the settings list')]
    public function aSettingWithKeyShouldNotAppearInTheSettingsList(string $key): void
    {
        $this->getClient()->request('GET', '/admin/setting');
        $this->assertLastResponseStatus(Response::HTTP_OK);

        $this->assertSession()->pageTextNotContains($this->labelledEnumHelper->formatValue($key, SettingKeyEnum::class));
    }

    #[Given('the admin setting form has a key validation error')]
    public function theAdminSettingFormHasAKeyValidationError(): void
    {
        $this->assertUnprocessableFormResponse();
        $this->assertSession()->pageTextContains('Pasirinkite nustatymą.');
    }

    #[Given('the admin setting edit form has a validation error :message')]
    public function theAdminSettingEditFormHasAValidationError(string $message): void
    {
        $this->assertSettingValidationErrorOnEditForm($message);
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

    #[Given('the admin create setting form shows :text')]
    public function theAdminCreateSettingFormShows(string $text): void
    {
        $this->assertLastResponseStatus(Response::HTTP_OK);
        $this->assertSession()->addressMatches('#/admin/setting/new#');
        $this->assertSession()->pageTextContains($text);
    }

    #[Given('the admin create setting form should not have a key field')]
    public function theAdminCreateSettingFormShouldNotHaveAKeyField(): void
    {
        $this->assertLastResponseStatus(Response::HTTP_OK);
        Assert::same(0, $this->getClient()->getCrawler()->filter('select[name="Setting[key]"]')->count());
    }

    #[Given('the admin create setting form should not have a continue button')]
    public function theAdminCreateSettingFormShouldNotHaveAContinueButton(): void
    {
        $this->assertLastResponseStatus(Response::HTTP_OK);
        Assert::same(0, $this->getClient()->getCrawler()->filter('button.action-saveAndContinue')->count());
    }

    #[Given('I sort admin settings by value')]
    public function iSortAdminSettingsByValue(): void
    {
        $client = $this->getClient();
        $client->request('GET', '/admin/setting');
        $link = $client->getCrawler()->filterXPath('//thead//th[@data-column="value"]//a')->link();
        $client->click($link);
    }

    #[Given('settings should appear in value order :firstValue then :secondValue')]
    public function settingsShouldAppearInValueOrder(string $firstValue, string $secondValue): void
    {
        $pageText = $this->getClient()->getCrawler()->filter('table')->text();
        $firstPosition = mb_strpos($pageText, $firstValue);
        $secondPosition = mb_strpos($pageText, $secondValue);

        Assert::notFalse($firstPosition, sprintf('Setting value "%s" was not found on the page.', $firstValue));
        Assert::notFalse($secondPosition, sprintf('Setting value "%s" was not found on the page.', $secondValue));
        Assert::lessThan($firstPosition, $secondPosition);
    }

    #[Given('I search the admin settings list for :query')]
    public function iSearchTheAdminSettingsListFor(string $query): void
    {
        $this->getClient()->request('GET', '/admin/setting', ['query' => $query]);
    }

    #[Given('the admin settings list should highlight :text')]
    public function theAdminSettingsListShouldHighlight(string $text): void
    {
        $this->assertLastResponseStatus(Response::HTTP_OK);

        $searchableCells = $this->getClient()->getCrawler()->filter('td.searchable');
        Assert::greaterThan($searchableCells->count(), 0, 'No searchable settings cells were found on the page.');

        foreach ($searchableCells as $cell) {
            if (str_contains(trim($cell->textContent ?? ''), $text)) {
                return;
            }
        }

        Assert::fail(sprintf('Searchable cell containing "%s" was not found on the page.', $text));
    }

    #[Given('the admin settings list should not show setting key label :label')]
    public function theAdminSettingsListShouldNotShowSettingKeyLabel(string $label): void
    {
        $this->assertLastResponseStatus(Response::HTTP_OK);

        foreach ($this->getClient()->getCrawler()->filter('table tbody tr') as $row) {
            Assert::false(str_contains($row->textContent ?? '', $label));
        }
    }

    private function submitAdminSettingCreateForm(string $key): void
    {
        $client = $this->getClient();
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

    private function submitAdminSettingValue(string $value, string $submitButton): void
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
                    'btn' => $submitButton,
                ],
            ],
        ]);
    }

    private function assertSettingValidationErrorOnEditForm(string $message): void
    {
        $this->assertLastResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertSession()->addressMatches('#/admin/setting/\d+/edit#');
        $this->assertSession()->pageTextContains($message);
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
