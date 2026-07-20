<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use App\Entity\AdminInvitation;
use App\Entity\ResetPasswordRequest;
use App\Entity\RoleEnum;
use App\Repository\AdminInvitationRepository;
use App\Repository\AdminRepository;
use App\Service\Admin\AdminInvitationService;
use App\Service\Admin\AdminMailer;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webmozart\Assert\Assert;

final class AccountContext extends RawMinkContext implements Context
{
    private ?string $invitationPlainToken = null;
    private ?string $storedInvitationTokenHash = null;
    private ?string $rememberedSessionId = null;
    private ?int $rememberedAccountId = null;
    private ?int $lastDeletedAdminId = null;

    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly AdminInvitationRepository $invitationRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslatorInterface $translator,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[When('I remember the account id for :email')]
    public function iRememberTheAccountIdFor(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);
        Assert::notNull($admin->getId());

        $this->rememberedAccountId = $admin->getId();
    }

    #[When('I visit the admin account detail page for :email')]
    public function iVisitTheAdminAccountDetailPageFor(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);
        Assert::notNull($admin->getId());

        $this->getClient()->request('GET', '/admin/admin/'.$admin->getId());
    }

    #[When('I visit the admin account detail page for the remembered account id')]
    public function iVisitTheAdminAccountDetailPageForTheRememberedAccountId(): void
    {
        Assert::notNull($this->rememberedAccountId);

        $this->getClient()->request('GET', '/admin/admin/'.$this->rememberedAccountId);
    }

    #[When('I visit the admin accounts list page')]
    public function iVisitTheAdminAccountsListPage(): void
    {
        $this->getClient()->request('GET', '/admin/admin');
    }

    #[When('I search admin accounts for :query')]
    public function iSearchAdminAccountsFor(string $query): void
    {
        $this->getClient()->request('GET', '/admin/admin', ['query' => $query]);
    }

    #[When('I sort admin accounts by role')]
    public function iSortAdminAccountsByRole(): void
    {
        $client = $this->getClient();
        $link = $client->getCrawler()->filterXPath('//thead//a[contains(normalize-space(.), "Rolė")]')->link();
        $client->click($link);
    }

    #[Then('accounts should appear in this order:')]
    public function accountsShouldAppearInThisOrder(TableNode $accounts): void
    {
        $pageText = $this->getClient()->getCrawler()->filter('table')->text();
        $previousPosition = -1;

        foreach ($accounts->getColumn(0) as $email) {
            $position = mb_strpos($pageText, $email);
            Assert::notFalse($position, sprintf('Account "%s" was not found on the page.', $email));
            Assert::greaterThan($position, $previousPosition, sprintf('Account "%s" is out of order.', $email));
            $previousPosition = $position;
        }
    }

    #[When('I create an admin account with email :email first name :firstName last name :lastName role :role and two-factor :twoFactor')]
    public function iCreateAnAdminAccount(
        string $email,
        string $firstName,
        string $lastName,
        string $role,
        string $twoFactor,
    ): void {
        $client = $this->getClient();
        $client->request('GET', '/admin/admin/new');
        $crawler = $client->getCrawler();
        $formNode = $crawler->filter('form.ea-new-form');
        Assert::greaterThan($formNode->count(), 0, 'Account create form was not found on the page.');

        $form = $formNode->form();
        $roleValue = RoleEnum::fromName(strtoupper($role))->value;
        $adminData = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'adminRole' => $roleValue,
            '_token' => $form['Admin[_token]']->getValue(),
        ];
        if ($twoFactor === 'enabled') {
            $adminData['emailTwoFactorEnabled'] = '1';
        }

        $client->request('POST', '/admin/admin/new', [
            'Admin' => $adminData,
            'ea' => [
                'newForm' => [
                    'btn' => 'saveAndReturn',
                ],
            ],
        ]);
    }

    #[When('admin account :email is deactivated for session invalidation')]
    public function adminAccountIsDeactivatedForSessionInvalidation(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);
        Assert::notNull($admin->getId());

        $admin->setActive(false);
        $this->entityManager->flush();
    }

    #[When('admin account :email is soft deleted directly')]
    public function adminAccountIsSoftDeletedDirectly(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);
        Assert::notNull($admin->getId());

        $admin
            ->setActive(false)
            ->setDeletedAt(new \DateTimeImmutable())
            ->setEmail(sprintf('deleted-session-%d@deleted.invalid', $admin->getId()))
            ->setRoles([]);
        $this->entityManager->flush();
    }

    #[When('admin account :email has two-factor disabled directly')]
    public function adminAccountHasTwoFactorDisabledDirectly(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        $admin->setEmailTwoFactorEnabled(false);
        $this->entityManager->flush();
    }

    #[When('admin account :email has role changed directly to :role')]
    public function adminAccountHasRoleChangedDirectly(string $email, string $role): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        $admin->setRoles([RoleEnum::fromName(strtoupper($role))->value]);
        $this->entityManager->flush();
    }

    #[Then('I should be on the admin FAQ page')]
    public function iShouldBeOnTheAdminFaqPage(): void
    {
        $this->assertSession()->addressMatches('/\/admin\/faq$/');
    }

    #[When('I edit admin account :email setting email to :newEmail and active to :active')]
    public function iEditAdminAccount(string $email, string $newEmail, string $active): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);
        Assert::notNull($admin->getId());

        $client = $this->getClient();
        $client->request('GET', '/admin/admin/'.$admin->getId().'/edit');
        $crawler = $client->getCrawler();
        $formNode = $crawler->filter('form.ea-edit-form');
        Assert::greaterThan($formNode->count(), 0, 'Account edit form was not found on the page.');

        $form = $formNode->form();
        $form['Admin[email]'] = $newEmail;

        if ($active === 'active') {
            $form['Admin[active]']->tick();
        } else {
            $form['Admin[active]']->untick();
        }

        $client->submit($form);
    }

    #[When('I edit admin account :email changing role to :role')]
    public function iEditAdminAccountChangingRole(string $email, string $role): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);
        Assert::notNull($admin->getId());

        $client = $this->getClient();
        $client->request('GET', '/admin/admin/'.$admin->getId().'/edit');
        $crawler = $client->getCrawler();
        $formNode = $crawler->filter('form.ea-edit-form');
        Assert::greaterThan($formNode->count(), 0, 'Account edit form was not found on the page.');

        $form = $formNode->form();
        $roleValue = RoleEnum::fromName(strtoupper($role))->value;
        $form['Admin[adminRole]'] = $roleValue;

        $client->submit($form);
    }

    #[Then('admin :email should have role :role')]
    public function adminShouldHaveRole(string $email, string $role): void
    {
        $this->entityManager->clear();

        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);
        Assert::same($admin->getPrimaryRole(), RoleEnum::fromName(strtoupper($role)));
    }

    #[When('I delete admin account :email')]
    public function iDeleteAdminAccount(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);
        Assert::notNull($admin->getId());

        $this->lastDeletedAdminId = $admin->getId();

        $client = $this->getClient();
        $client->request('GET', '/admin/admin/'.$admin->getId());
        $crawler = $client->getCrawler();
        $deleteToken = $crawler->filter('#action-confirmation-form input[name="token"]')->attr('value');
        Assert::notNull($deleteToken);

        $client->request('POST', '/admin/admin/'.$admin->getId().'/delete', [
            'token' => $deleteToken,
        ]);
    }

    #[Then('admin :email should have two-factor disabled')]
    public function adminShouldHaveTwoFactorDisabled(string $email): void
    {
        $this->entityManager->clear();

        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);
        Assert::false($admin->isEmailTwoFactorEnabled());
    }

    #[Then('an invitation should exist for admin :email')]
    public function anInvitationShouldExistForAdmin(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        $invitations = $this->invitationRepository->findBy(['admin' => $admin]);
        Assert::count($invitations, 1);
    }

    #[Then('no invitation should exist for admin :email')]
    public function noInvitationShouldExistForAdmin(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);
        Assert::count($this->invitationRepository->findBy(['admin' => $admin]), 0);
    }

    #[Given('admin :email has a pending account invitation')]
    public function adminHasAPendingAccountInvitation(string $email): void
    {
        $this->createInvitation($email, new \DateTimeImmutable('+1 day'));
    }

    #[Given('admin :email has an expired account invitation')]
    public function adminHasAnExpiredAccountInvitation(string $email): void
    {
        $this->createInvitation($email, new \DateTimeImmutable('-1 day'));
    }

    #[When('I open the account invitation link')]
    public function iOpenTheAccountInvitationLink(): void
    {
        Assert::notNull($this->invitationPlainToken);

        $this->getClient()->request('GET', '/admin/invitation/'.$this->invitationPlainToken);
    }

    #[When('I remember the current session id')]
    public function iRememberTheCurrentSessionId(): void
    {
        $session = $this->getClient()->getRequest()->getSession();
        $session->start();
        $this->rememberedSessionId = $session->getId();
        Assert::notEmpty($this->rememberedSessionId);
    }

    #[When('I set the account invitation password to :password')]
    public function iSetTheAccountInvitationPasswordTo(string $password): void
    {
        Assert::notNull($this->invitationPlainToken);

        $client = $this->getClient();
        $client->request('GET', '/admin/invitation/'.$this->invitationPlainToken);
        $csrfToken = $client->getCrawler()->filter('input[name="_csrf_token"]')->attr('value');
        Assert::notNull($csrfToken);

        $client->request('POST', '/admin/invitation/'.$this->invitationPlainToken, [
            '_csrf_token' => $csrfToken,
            'password' => $password,
            'password_confirm' => $password,
        ]);
    }

    #[Then('I should be on the admin two-factor login page')]
    public function iShouldBeOnTheAdminTwoFactorLoginPage(): void
    {
        $this->assertSession()->addressMatches('/\/admin\/login\/2fa$/');
        $this->assertSession()->pageTextContains('Autentifikacijos kodas');
    }

    #[Then('the session id should have changed')]
    public function theSessionIdShouldHaveChanged(): void
    {
        Assert::notNull($this->rememberedSessionId);
        Assert::notSame(
            $this->getClient()->getRequest()->getSession()->getId(),
            $this->rememberedSessionId,
        );
    }

    #[Then('admin :email should have a last active time')]
    public function adminShouldHaveALastActiveTime(string $email): void
    {
        $this->entityManager->clear();

        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);
        Assert::notNull($admin->getLastActiveAt());
    }

    #[When('I remember the invitation token hash for admin :email')]
    public function iRememberTheInvitationTokenHashForAdmin(string $email): void
    {
        $this->storedInvitationTokenHash = $this->getInvitationTokenHashForAdmin($email);
        Assert::notNull($this->storedInvitationTokenHash);
    }

    #[When('I resend the account invitation for :email')]
    public function iResendTheAccountInvitationFor(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);
        Assert::notNull($admin->getId());

        $client = $this->getClient();
        $client->request('GET', '/admin/admin/'.$admin->getId());
        $formNode = $client->getCrawler()->filter('form[action*="/resend-invitation"]');
        Assert::greaterThan($formNode->count(), 0, 'Resend invitation form was not found on the page.');
        $client->submit($formNode->form());
    }

    #[When('the mail transport fails while resending the account invitation for :email')]
    public function theMailTransportFailsWhileResendingTheAccountInvitationFor(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        $failingMailer = new class implements MailerInterface {
            public function send(RawMessage $message, ?Envelope $envelope = null): void
            {
                throw new TransportException('Simulated mail transport failure.');
            }
        };

        $invitationService = new AdminInvitationService(
            $this->invitationRepository,
            $this->entityManager,
            new AdminMailer($failingMailer, $this->translator, 'noreply@example.com', 'Test'),
            $this->urlGenerator,
        );

        $transportFailed = false;
        try {
            $invitationService->createAndSend($admin);
        } catch (TransportExceptionInterface) {
            $transportFailed = true;
        }

        Assert::true($transportFailed, 'The simulated mail transport did not fail.');
    }

    #[When('I resend the account invitation for :email without a valid CSRF token')]
    public function iResendTheAccountInvitationWithoutAValidCsrfToken(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);
        Assert::notNull($admin->getId());

        $this->getClient()->request(
            'POST',
            '/admin/admin/'.$admin->getId().'/resend-invitation?token=invalid',
        );
    }

    #[Then('admin :email should have a renewed invitation')]
    public function adminShouldHaveARenewedInvitation(string $email): void
    {
        Assert::notNull($this->storedInvitationTokenHash);

        $newTokenHash = $this->getInvitationTokenHashForAdmin($email);
        Assert::notNull($newTokenHash);
        Assert::notSame($this->storedInvitationTokenHash, $newTokenHash);
    }

    #[Then('admin :email should retain the previous invitation')]
    public function adminShouldRetainThePreviousInvitation(string $email): void
    {
        Assert::notNull($this->storedInvitationTokenHash);
        Assert::same($this->getInvitationTokenHashForAdmin($email), $this->storedInvitationTokenHash);
    }

    #[Then('I should see account :email in the accounts list')]
    public function iShouldSeeAccountInTheAccountsList(string $email): void
    {
        $this->assertSession()->pageTextContains($email);
    }

    #[Then('I should not see account :email in the accounts list')]
    public function iShouldNotSeeAccountInTheAccountsList(string $email): void
    {
        $this->assertSession()->pageTextNotContains($email);
    }

    #[Then('admin account :email should not exist')]
    public function adminAccountShouldNotExist(string $email): void
    {
        $this->entityManager->clear();
        Assert::null($this->adminRepository->findOneByEmail($email));
    }

    #[Then('exactly one active admin account should exist with email :email')]
    public function exactlyOneActiveAdminAccountShouldExistWithEmail(string $email): void
    {
        $this->entityManager->clear();
        Assert::count($this->adminRepository->findBy(['email' => $email, 'deletedAt' => null]), 1);
    }

    #[Then('admin account :email should be soft deleted')]
    public function adminAccountShouldBeSoftDeleted(string $email): void
    {
        $this->entityManager->clear();

        Assert::null($this->adminRepository->findOneByEmail($email));
        Assert::notNull($this->lastDeletedAdminId);

        $deletedAdmin = $this->adminRepository->find($this->lastDeletedAdminId);
        Assert::notNull($deletedAdmin);
        Assert::true($deletedAdmin->isDeleted());
        Assert::false($deletedAdmin->isActive());
        Assert::same($deletedAdmin->getFirstName(), '');
        Assert::same($deletedAdmin->getLastName(), '');
        Assert::startsWith($deletedAdmin->getEmail(), 'deleted-');
        Assert::endsWith($deletedAdmin->getEmail(), '@deleted.invalid');
        Assert::null($deletedAdmin->getPrimaryRole());
        Assert::false($deletedAdmin->isEmailTwoFactorEnabled());
        Assert::null($deletedAdmin->getAuthCode());
        Assert::null($deletedAdmin->getLastActiveAt());
        Assert::count($this->invitationRepository->findBy(['admin' => $deletedAdmin]), 0);
        Assert::same(
            $this->entityManager->getRepository(ResetPasswordRequest::class)->count(['user' => $deletedAdmin]),
            0,
        );
    }

    private function getClient(): KernelBrowser
    {
        $client = $this->getSession()->getDriver()->getClient();
        Assert::isInstanceOf($client, KernelBrowser::class);

        return $client;
    }

    private function getInvitationTokenHashForAdmin(string $email): ?string
    {
        $this->entityManager->clear();

        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        $invitations = $this->invitationRepository->findBy(['admin' => $admin]);
        Assert::count($invitations, 1);

        return $invitations[0]->getTokenHash();
    }

    private function createInvitation(string $email, \DateTimeImmutable $expiresAt): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        foreach ($this->invitationRepository->findBy(['admin' => $admin]) as $invitation) {
            $this->entityManager->remove($invitation);
        }

        $this->invitationPlainToken = str_repeat('a', 64);
        $this->entityManager->persist(new AdminInvitation(
            $admin,
            hash('sha256', $this->invitationPlainToken),
            $expiresAt,
        ));
        $this->entityManager->flush();
    }
}
