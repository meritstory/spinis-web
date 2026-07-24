<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Complainant;
use App\Repository\ComplainantRepository;
use App\Service\Viisp\ViispClientInterface;
use App\Service\Viisp\ViispIdentityData;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

final class ViispAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private readonly ViispClientInterface $viispClient,
        private readonly ComplainantRepository $complainantRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly ManagerRegistry $managerRegistry,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function supports(Request $request): bool
    {
        return $request->attributes->get('_route') === 'viisp_login_postback';
    }

    public function authenticate(Request $request): Passport
    {
        $ticket = $request->request->getString('ticket');

        if ($ticket === '') {
            throw new CustomUserMessageAuthenticationException('viisp.error.failed_to_login');
        }

        try {
            $identity = $this->viispClient->getIdentity($ticket);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);

            throw new CustomUserMessageAuthenticationException('viisp.error.identity_exchange_failed', previous: $exception);
        }

        return new SelfValidatingPassport(
            new UserBadge($identity->personalCode, function (string $personalCode) use ($identity): Complainant {
                return $this->findOrCreateComplainant($personalCode, $identity);
            }),
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate('my_complaints'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): RedirectResponse
    {
        /** @var FlashBagAwareSessionInterface $session */
        $session = $request->getSession();
        $session->getFlashBag()->add('viisp_error', $exception->getMessageKey());

        return new RedirectResponse($this->urlGenerator->generate('home'));
    }

    private function findOrCreateComplainant(string $personalCode, ViispIdentityData $identity): Complainant
    {
        $entityManager = $this->entityManager;
        $complainant = $this->complainantRepository->findOneByPersonalCode($personalCode);

        if ($complainant === null) {
            $complainant = new Complainant();
            $complainant->setPersonalCode($personalCode);
            $entityManager->persist($complainant);

            try {
                $entityManager->flush();
            } catch (UniqueConstraintViolationException) {
                // A concurrent first-login for the same person raced us and won.
                // Doctrine closes the EntityManager on any flush exception, so a
                // fresh one is needed before it can be used again.
                /** @var EntityManagerInterface $entityManager */
                $entityManager = $this->managerRegistry->resetManager();
                /** @var ComplainantRepository $complainantRepository */
                $complainantRepository = $entityManager->getRepository(Complainant::class);
                $complainant = $complainantRepository->findOneByPersonalCode($personalCode);

                if ($complainant === null) {
                    throw new \RuntimeException('VIISP: complainant lookup failed after a concurrent insert conflict.');
                }
            }
        }

        $complainant->setFirstName($identity->firstName);
        $complainant->setLastName($identity->lastName);
        $entityManager->flush();

        return $complainant;
    }
}
