<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\FaqRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(FaqRepository $faqRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'faqs' => $faqRepository->findAllOrderedByPosition(),
        ]);
    }
}
