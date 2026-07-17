<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ManoSkundaiController extends AbstractController
{
    #[Route('/mano-skundai', name: 'mano_skundai', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        return $this->render('mano_skundai/index.html.twig');
    }
}
