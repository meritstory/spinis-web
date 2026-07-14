<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Faq;
use App\Repository\FaqRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[OAT\Tag(name: 'FAQ')]
class FaqController extends AbstractFOSRestController
{
    use ResponseTrait;

    public function __construct(
        private readonly FaqRepository $faqRepository,
    ) {
    }

    #[Route('/api/faq', methods: [Request::METHOD_GET])]
    #[OAT\Response(
        response: Response::HTTP_OK,
        description: 'Returns all FAQs ordered by position',
        content: new OAT\JsonContent(
            type: 'array',
            items: new OAT\Items(ref: new Model(type: Faq::class, groups: ['faq']))
        )
    )]
    public function list(): Response
    {
        return $this->handleResponseView(
            $this->faqRepository->findAllOrderedByPosition(),
            Response::HTTP_OK,
            ['faq'],
        );
    }
}
