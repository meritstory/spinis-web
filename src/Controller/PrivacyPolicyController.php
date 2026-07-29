<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\DocumentKeyEnum;
use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PrivacyPolicyController extends AbstractController
{
    #[Route('/privacy-policy', name: 'privacy_policy', methods: [Request::METHOD_GET])]
    public function index(DocumentRepository $documentRepository): Response
    {
        return $this->render('privacy_policy/index.html.twig', [
            'document' => $documentRepository->findOneByKey(DocumentKeyEnum::PRIVACY_POLICY),
        ]);
    }
}
