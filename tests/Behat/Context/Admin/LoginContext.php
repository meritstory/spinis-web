<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Admin;

use App\Entity\Admin;
use App\Entity\ResetPasswordRequest;
use App\Repository\AdminRepository;
use App\Service\Admin\AdminHomeRouteResolver;
use App\Tests\Behat\Support\PasswordResetTokenStore;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Step\Given;
use Behat\Step\Then;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use Webmozart\Assert\Assert;

final class LoginContext extends RawMinkContext implements Context
{
    private ?string $rememberedAuthenticationCode = null;

    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly ResetPasswordHelperInterface $resetPasswordHelper,
        private readonly PasswordResetTokenStore $passwordResetTokenStore,
        private readonly AdminHomeRouteResolver $homeRouteResolver,
    ) {
    }

    #[Given('I submit the admin login form with email :email and password :password')]
    public function iSubmitAdminLoginForm(string $email, string $password): void
    {
        $this->submitLoginCredentials($email, $password);
    }

    #[Given('I confirm admin login with the latest authentication code for :email')]
    public function iConfirmAdminLoginWithLatestCode(string $email): void
    {
        $this->submitVerificationCode($this->getLatestAuthenticationCode($email));
    }

    #[Given('I am logged in to the admin panel as :email with password :password')]
    public function iAmLoggedInToTheAdminPanel(string $email, string $password): void
    {
        $this->submitLoginCredentials($email, $password);

        // The authentication code is written by the application in a rebooted kernel, so this
        // step has to refresh the ORM state itself between its own two requests.
        $this->entityManager->clear();

        $this->submitVerificationCode($this->getLatestAuthenticationCode($email));
    }

    #[Given('I am logged in to the admin panel as :email with password :password without two-factor')]
    public function iAmLoggedInToTheAdminPanelWithoutTwoFactor(string $email, string $password): void
    {
        $this->submitLoginCredentials($email, $password);
    }

    #[Given('I confirm admin login with authentication code :code')]
    public function iConfirmAdminLoginWithCode(string $code): void
    {
        $this->submitVerificationCode($code);
    }

    #[Given('I visit the admin two-factor login page')]
    public function iVisitTheAdminTwoFactorLoginPage(): void
    {
        $this->getClient()->request('GET', '/admin/login/2fa');
    }

    #[Given('I cancel admin two-factor authentication')]
    public function iCancelAdminTwoFactorAuthentication(): void
    {
        $client = $this->getClient();
        $client->request('GET', '/admin/login/2fa');
        $logoutUrl = $client->getCrawler()->filter('a.btn-secondary')->attr('href');
        Assert::string($logoutUrl);
        $client->request('GET', $logoutUrl);
    }

    #[Given('I resend the admin authentication code')]
    public function iResendAdminAuthenticationCode(): void
    {
        $client = $this->getClient();
        $client->request('GET', '/admin/login/2fa');
        $csrfToken = $this->getCsrfToken($client->getCrawler());

        $client->request('POST', '/admin/login/2fa/resend', [
            '_csrf_token' => $csrfToken,
        ]);
    }

    #[Given('I remember the current authentication code for :email')]
    public function iRememberTheCurrentAuthenticationCode(string $email): void
    {
        $this->rememberedAuthenticationCode = $this->getLatestAuthenticationCode($email);
    }

    #[Given('I confirm admin login with the remembered authentication code')]
    public function iConfirmAdminLoginWithRememberedCode(): void
    {
        Assert::notNull($this->rememberedAuthenticationCode);
        $this->submitVerificationCode($this->rememberedAuthenticationCode);
    }

    #[Given('I open the admin forgot password form')]
    public function iOpenAdminForgotPasswordForm(): void
    {
        $this->getClient()->request('GET', '/admin/login?step=forgot');
    }

    #[Given('I request admin password reset for email :email')]
    public function iRequestAdminPasswordReset(string $email): void
    {
        $this->getClient()->request('GET', '/admin/login?step=forgot');
        $this->submitForgotPassword($email);
    }

    #[Given('a password reset token was issued for admin :email')]
    public function aPasswordResetTokenWasIssuedForAdmin(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        $resetToken = $this->resetPasswordHelper->generateResetToken($admin);
        $this->passwordResetTokenStore->set($resetToken->getToken());
    }

    #[Given('I reset admin password using the stored reset token to :password')]
    public function iResetAdminPasswordUsingStoredToken(string $password): void
    {
        $client = $this->getClient();
        $token = $this->passwordResetTokenStore->get();

        Assert::notNull($token);

        $client->request('GET', '/admin/reset-password/'.$token);
        $csrfToken = $this->getCsrfToken($client->getCrawler());

        $client->request('POST', '/admin/reset-password', [
            '_csrf_token' => $csrfToken,
            'password' => $password,
            'password_confirm' => $password,
        ]);
    }

    #[Given('I visit the remembered password reset link')]
    public function iVisitTheRememberedPasswordResetLink(): void
    {
        $token = $this->passwordResetTokenStore->get();
        Assert::notNull($token);

        $this->getClient()->request('GET', '/admin/reset-password/'.$token);
    }

    #[Given('admin :email should have exactly :count password reset request(s)')]
    public function adminShouldHaveExactlyPasswordResetRequests(string $email, int $count): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        $actualCount = $this->entityManager->getRepository(ResetPasswordRequest::class)->count(['user' => $admin]);
        Assert::same($count, $actualCount);
    }

    #[Given('the password reset throttle has passed for admin :email')]
    public function thePasswordResetThrottleHasPassedForAdmin(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        $this->entityManager->getConnection()->executeStatement(
            'UPDATE reset_password_request SET requested_at = :requested_at WHERE user_id = :user_id',
            [
                'requested_at' => (new \DateTimeImmutable('-10 minutes'))->format('Y-m-d H:i:s'),
                'user_id' => $admin->getId(),
            ],
        );
    }

    #[Given('the authentication code for admin :email has expired')]
    public function theAuthenticationCodeForAdminHasExpired(string $email): void
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        $admin->setAuthCodeExpiresAt(new \DateTimeImmutable('-1 minute'));
        $this->entityManager->flush();
    }

    #[Then('I should be on the admin accounts page')]
    public function iShouldBeOnTheAdminAccountsPage(): void
    {
        $this->assertSession()->addressMatches('#/admin/admin#');
    }

    #[Then('I should be on the admin login page')]
    public function iShouldBeOnTheAdminLoginPage(): void
    {
        $this->assertSession()->addressMatches('#/admin/login#');
    }

    #[Given('I should be on the admin home page')]
    public function iShouldBeOnTheAdminHomePage(): void
    {
        $client = $this->getClient();
        $user = $client->getContainer()->get('security.token_storage')->getToken()?->getUser();
        Assert::isInstanceOf($user, Admin::class);

        $homePath = $client->getContainer()->get('router')->generate($this->homeRouteResolver->resolve($user));
        $this->assertSession()->addressMatches('#'.preg_quote($homePath, '#').'($|\\?)#');
    }

    #[Given('I visit the logout page')]
    public function iVisitTheLogoutPage(): void
    {
        $client = $this->getClient();
        $client->request('GET', '/admin');
        $logoutUrl = $client->getCrawler()->filter('a.user-action')->reduce(
            static fn (\Symfony\Component\DomCrawler\Crawler $node): bool => str_contains($node->text(), 'Atsijungti') || str_contains($node->attr('href') ?? '', '/admin/logout')
        )->first()->attr('href');

        Assert::notNull($logoutUrl);
        $client->request('GET', $logoutUrl);
    }

    private function submitForgotPassword(string $email): void
    {
        $client = $this->getClient();
        $csrfToken = $this->getCsrfToken($client->getCrawler());

        $client->request('POST', '/admin/forgot-password', [
            '_csrf_token' => $csrfToken,
            'email' => $email,
        ]);
    }

    private function submitLoginCredentials(string $email, string $password): void
    {
        $client = $this->getClient();
        $client->request('GET', '/admin/login');
        $csrfToken = $this->getCsrfToken($client->getCrawler());

        $client->request('POST', '/admin/login_check', [
            '_csrf_token' => $csrfToken,
            'email' => $email,
            'password' => $password,
        ]);
    }

    private function submitVerificationCode(string $code): void
    {
        $client = $this->getClient();
        $client->request('GET', '/admin/login/2fa');
        $csrfToken = $this->getCsrfToken($client->getCrawler());

        $client->request('POST', '/admin/login/2fa_check', [
            '_csrf_token' => $csrfToken,
            '_auth_code' => $code,
        ]);
    }

    private function getLatestAuthenticationCode(string $email): string
    {
        $admin = $this->adminRepository->findOneByEmail($email);
        Assert::notNull($admin);

        $code = $admin->getAuthCode();
        Assert::notNull($code);

        return $code;
    }

    private function getCsrfToken(\Symfony\Component\DomCrawler\Crawler $crawler): string
    {
        $token = $crawler->filter('input[name="_csrf_token"]')->attr('value');
        Assert::string($token);

        return $token;
    }

    private function getClient(): KernelBrowser
    {
        $client = $this->getSession()->getDriver()->getClient();
        Assert::isInstanceOf($client, KernelBrowser::class);

        return $client;
    }
}
