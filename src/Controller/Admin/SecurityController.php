<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use App\Security\AdminAuthenticationHelper;
use App\Security\AdminPasswordPolicy;
use App\Service\Admin\AdminInvitationService;
use App\Service\Admin\AdminMailer;
use Doctrine\ORM\EntityManagerInterface;
use Scheb\TwoFactorBundle\Controller\FormController;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Email\Generator\CodeGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class SecurityController extends AbstractController
{
    use ResetPasswordControllerTrait;

    private const string CSRF_TOKEN_ID = 'authenticate';

    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly AdminRepository $adminRepository,
        private readonly ResetPasswordHelperInterface $resetPasswordHelper,
        private readonly AdminMailer $adminMailer,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $entityManager,
        private readonly FormController $twoFactorFormController,
        private readonly CodeGenerator $twoFactorCodeGenerator,
        private readonly AdminInvitationService $invitationService,
        private readonly AdminAuthenticationHelper $authenticationHelper,
        private readonly AdminPasswordPolicy $passwordPolicy,
    ) {
    }

    #[Route('/admin/login', name: 'admin_login', methods: [Request::METHOD_GET])]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        if ($this->getUser() instanceof Admin) {
            return $this->redirectToRoute('admin');
        }

        if ($request->query->getString('step') === 'forgot') {
            return $this->renderLogin('forgot');
        }

        if ($request->query->getString('step') === 'forgot_sent') {
            return $this->renderLogin('forgot_sent');
        }

        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->renderLogin('login', [
            'error' => $this->resolveLoginError($error),
            'last_email' => $authenticationUtils->getLastUsername(),
        ]);
    }

    #[Route('/admin/login_check', name: 'admin_login_check', methods: [Request::METHOD_POST])]
    public function loginCheck(): never
    {
        throw new \LogicException('Login check must be handled by the security firewall.');
    }

    #[Route('/admin/login/2fa', name: 'admin_2fa_login', methods: [Request::METHOD_GET])]
    public function twoFactorLogin(Request $request): Response
    {
        return $this->twoFactorFormController->form($request);
    }

    #[Route('/admin/login/2fa_check', name: 'admin_2fa_login_check', methods: [Request::METHOD_POST])]
    public function twoFactorLoginCheck(): never
    {
        throw new \LogicException('Two-factor login check must be handled by the security firewall.');
    }

    #[Route('/admin/login/2fa/resend', name: 'admin_2fa_resend', methods: [Request::METHOD_POST])]
    public function twoFactorResend(Request $request): Response
    {
        if (!$this->isCsrfTokenValid('two_factor', $request->request->getString('_csrf_token'))) {
            $this->addFlash('danger', $this->translator->trans('login.error.invalid_request'));

            return $this->redirectToRoute('admin_2fa_login');
        }

        $user = $this->getUser();

        if ($user instanceof Admin) {
            $this->twoFactorCodeGenerator->generateAndSend($user);
        }

        $this->addFlash('info', $this->translator->trans('login.resend_success'));

        return $this->redirectToRoute('admin_2fa_login');
    }

    #[Route('/admin/forgot-password', name: 'admin_forgot_password', methods: [Request::METHOD_POST])]
    public function forgotPassword(Request $request): Response
    {
        if (!$this->isCsrfTokenValid(self::CSRF_TOKEN_ID, $request->request->getString('_csrf_token'))) {
            return $this->renderLogin('forgot', [
                'error' => $this->translator->trans('login.error.invalid_request'),
            ]);
        }

        $email = $request->request->getString('email');
        $admin = $this->adminRepository->findOneByEmail($email);

        if ($admin !== null) {
            try {
                $resetToken = $this->resetPasswordHelper->generateResetToken($admin);
                $this->adminMailer->sendPasswordResetLink(
                    $admin->getEmail(),
                    $this->urlGenerator->generate(
                        'admin_reset_password_link',
                        ['token' => $resetToken->getToken()],
                        UrlGeneratorInterface::ABSOLUTE_URL,
                    ),
                );
            } catch (ResetPasswordExceptionInterface) {
            }
        }

        return $this->redirectToRoute('admin_login', ['step' => 'forgot_sent']);
    }

    #[Route('/admin/reset-password/{token}', name: 'admin_reset_password_link', methods: [Request::METHOD_GET])]
    public function resetPasswordLink(string $token): Response
    {
        if ($this->getUser() instanceof Admin) {
            return $this->redirectToRoute('admin');
        }

        try {
            $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface) {
            return $this->renderResetPasswordInvalidToken();
        }

        $this->storeTokenInSession($token);

        return $this->redirectToRoute('admin_reset_password');
    }

    #[Route('/admin/reset-password', name: 'admin_reset_password', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function resetPassword(Request $request): Response
    {
        if ($this->getUser() instanceof Admin) {
            return $this->redirectToRoute('admin');
        }

        $token = $this->getTokenFromSession();
        if ($token === null) {
            return $this->renderResetPasswordInvalidToken();
        }

        if ($request->isMethod(Request::METHOD_POST)) {
            if (!$this->isCsrfTokenValid(self::CSRF_TOKEN_ID, $request->request->getString('_csrf_token'))) {
                return $this->renderResetPasswordForm($this->translator->trans('login.error.invalid_request'));
            }

            $password = $request->request->getString('password');
            $passwordConfirm = $request->request->getString('password_confirm');

            $passwordError = $this->validateSubmittedPassword($password, $passwordConfirm);
            if ($passwordError !== null) {
                return $this->renderResetPasswordForm($passwordError);
            }

            try {
                /** @var Admin $admin */
                $admin = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
                $this->resetPasswordHelper->removeResetRequest($token);
                $admin->setPassword($this->passwordHasher->hashPassword($admin, $password));
                $this->entityManager->flush();
                $this->cleanSessionAfterReset();
            } catch (ResetPasswordExceptionInterface) {
                return $this->renderResetPasswordInvalidToken();
            }

            $this->addFlash('success', $this->translator->trans('login.reset.success'));

            return $this->redirectToRoute('admin_login');
        }

        try {
            $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface) {
            return $this->renderResetPasswordInvalidToken();
        }

        return $this->renderResetPasswordForm();
    }

    #[Route(
        '/admin/invitation/{token}',
        name: 'admin_invitation_link',
        requirements: ['token' => '[a-f0-9]{64}'],
        methods: [Request::METHOD_GET, Request::METHOD_POST],
    )]
    public function invitation(Request $request, string $token): Response
    {
        if ($this->getUser() instanceof Admin) {
            return $this->redirectToRoute('admin');
        }

        $invitation = $this->invitationService->validateToken($token);
        if ($invitation === null) {
            return $this->renderInvitationSetPasswordInvalidToken();
        }

        if ($request->isMethod(Request::METHOD_POST)) {
            if (!$this->isCsrfTokenValid(self::CSRF_TOKEN_ID, $request->request->getString('_csrf_token'))) {
                return $this->renderInvitationSetPasswordForm($token, $this->translator->trans('login.error.invalid_request'));
            }

            $password = $request->request->getString('password');
            $passwordConfirm = $request->request->getString('password_confirm');

            $passwordError = $this->validateSubmittedPassword($password, $passwordConfirm);
            if ($passwordError !== null) {
                return $this->renderInvitationSetPasswordForm($token, $passwordError);
            }

            $admin = $this->invitationService->consumeValidToken(
                $token,
                function (Admin $admin) use ($password): void {
                    $admin->setPassword($this->passwordHasher->hashPassword($admin, $password));
                },
            );
            if ($admin === null) {
                return $this->renderInvitationSetPasswordInvalidToken();
            }

            try {
                $authenticationResponse = $this->authenticationHelper->authenticateAfterPasswordSetup($admin);
            } catch (CustomUserMessageAccountStatusException) {
                return $this->renderInvitationSetPasswordInvalidToken();
            }

            if ($authenticationResponse !== null) {
                return $authenticationResponse;
            }

            if ($admin->isEmailAuthEnabled()) {
                return $this->redirectToRoute('admin_2fa_login');
            }

            return $this->redirectToRoute('admin');
        }

        return $this->renderInvitationSetPasswordForm($token);
    }

    /**
     * @param array<string, mixed> $extra
     */
    private function renderLogin(string $step, array $extra = []): Response
    {
        return $this->render('admin/login.html.twig', array_merge([
            'step' => $step,
            'page_title' => $this->translator->trans('app.name'),
            'csrf_token_intention' => self::CSRF_TOKEN_ID,
        ], $extra));
    }

    private function renderResetPasswordForm(?string $error = null): Response
    {
        return $this->render('admin/reset_password.html.twig', [
            'page_title' => $this->translator->trans('app.name'),
            'csrf_token_intention' => self::CSRF_TOKEN_ID,
            'error' => $error,
            'show_form' => true,
            'password_min_length' => $this->passwordPolicy->getMinLength(),
        ]);
    }

    private function renderResetPasswordInvalidToken(): Response
    {
        $this->cleanSessionAfterReset();

        return $this->render('admin/reset_password.html.twig', [
            'page_title' => $this->translator->trans('app.name'),
            'csrf_token_intention' => self::CSRF_TOKEN_ID,
            'error' => $this->translator->trans('login.reset.invalid_token'),
            'show_form' => false,
        ]);
    }

    private function renderInvitationSetPasswordForm(string $token, ?string $error = null): Response
    {
        return $this->render('admin/invitation_set_password.html.twig', [
            'page_title' => $this->translator->trans('admin.invitation.page_title'),
            'csrf_token_intention' => self::CSRF_TOKEN_ID,
            'error' => $error,
            'show_form' => true,
            'password_min_length' => $this->passwordPolicy->getMinLength(),
            'invitation_token' => $token,
        ]);
    }

    private function validateSubmittedPassword(string $password, string $passwordConfirm): ?string
    {
        $policyErrorKeys = $this->passwordPolicy->validateAll($password);
        if ($policyErrorKeys !== []) {
            return implode(' ', array_map(
                fn (string $errorKey): string => $this->translator->trans($errorKey, [
                    '%min%' => $this->passwordPolicy->getMinLength(),
                ]),
                $policyErrorKeys,
            ));
        }

        if ($password !== $passwordConfirm) {
            return $this->translator->trans('password.policy.mismatch');
        }

        return null;
    }

    private function renderInvitationSetPasswordInvalidToken(): Response
    {
        return $this->render('admin/invitation_set_password.html.twig', [
            'page_title' => $this->translator->trans('admin.invitation.page_title'),
            'csrf_token_intention' => self::CSRF_TOKEN_ID,
            'error' => $this->translator->trans('admin.invitation.invalid_token'),
            'show_form' => false,
        ]);
    }

    private function resolveLoginError(?AuthenticationException $error): ?string
    {
        if ($error === null) {
            return null;
        }

        if ($error->getMessageKey() === 'Invalid credentials.') {
            return $this->translator->trans('login.error.invalid_credentials');
        }

        return $this->translator->trans($error->getMessageKey(), $error->getMessageData());
    }
}
