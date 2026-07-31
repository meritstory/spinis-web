<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactsController extends AbstractController
{
    public function __construct(
        #[Autowire(env: 'GOOGLE_MAPS_API_KEY')]
        private readonly string $googleMapsApiKey,
    ) {
    }

    #[Route('/contacts', name: 'contacts', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        return $this->render('contacts/index.html.twig', [
            'googleMapsApiKey' => $this->googleMapsApiKey,
        ]);
    }
}