<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\FaqRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DukController extends AbstractController
{
    #[Route('/duk', name: 'duk', methods: [Request::METHOD_GET])]
    public function index(FaqRepository $faqRepository): Response
    {
        return $this->render('duk/index.html.twig', [
            'faqs' => $faqRepository->findAllOrderedByPosition(),
        ]);
    }
}
