<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Viisp\ViispClientInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ViispAuthController extends AbstractController
{
    public function __construct(
        private readonly ViispClientInterface $viispClient,
        private readonly UrlGeneratorInterface $urlGenerator,
        #[Target('viisp')]
        private readonly LoggerInterface $logger,
        private readonly string $viispSoapActionBaseUrl,
    ) {
    }

    #[Route('/viisp/login-submit', name: 'viisp_login_submit', methods: [Request::METHOD_GET])]
    public function loginSubmit(): Response
    {
        try {
            $ticket = $this->viispClient->getAuthenticationTicket(
                $this->urlGenerator->generate('viisp_login_postback', [], UrlGeneratorInterface::ABSOLUTE_URL),
            );
        } catch (\Throwable $exception) {
            $this->logger->error('VIISP: failed to obtain authentication ticket.', ['exception' => $exception]);
            $this->addFlash('viisp_error', 'viisp.error.failed_to_login');

            return $this->redirectToRoute('home');
        }

        return $this->render('viisp/login_submit.html.twig', [
            'action' => $this->viispSoapActionBaseUrl,
            'ticket' => $ticket,
        ]);
    }

    #[Route('/viisp/login-postback', name: 'viisp_login_postback', methods: [Request::METHOD_POST])]
    public function loginPostback(): never
    {
        throw new \LogicException('VIISP login postback must be handled by the security firewall.');
    }
}
