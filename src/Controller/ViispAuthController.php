<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Viisp\ViispClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ViispAuthController extends AbstractController
{
    public function __construct(
        private readonly ViispClientInterface $viispClient,
        #[Autowire(env: 'VIISP_SOAP_ACTION_BASE_URL')]
        private readonly string $viispSoapActionBaseUrl,
        #[Autowire(env: 'VIISP_POSTBACK_URL')]
        private readonly string $viispPostbackUrl,
    ) {
    }

    #[Route('/viisp/login-submit', name: 'viisp_login_submit', methods: [Request::METHOD_GET])]
    public function loginSubmit(): Response
    {
        try {
            $ticket = $this->viispClient->getAuthenticationTicket($this->viispPostbackUrl);
        } catch (\Throwable $exception) {
            \Sentry\captureException($exception);
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
