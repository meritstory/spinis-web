<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MyComplaintsController extends AbstractController
{
    #[Route('/my-complaints', name: 'my_complaints', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        return $this->render('my_complaints/index.html.twig');
    }
}