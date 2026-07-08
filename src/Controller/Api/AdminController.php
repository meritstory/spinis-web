<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Admin;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OAT;

/**
 * @method Admin getUser()
 */
#[Route('/api/admins')]
#[OAT\Tag(name: 'Admins')]
class AdminController extends AbstractFOSRestController
{
    use ResponseTrait;

    #[Route('/me', methods: [Request::METHOD_GET])]
    #[OAT\Response(
        response: Response::HTTP_OK,
        description: 'Returns the current admin',
        content: new OAT\JsonContent(ref: new Model(type: Admin::class, groups: ['me']))
    )]
    public function me(): Response
    {
        return $this->handleResponseView($this->getUser(), serializeGroups: ['me']);
    }
}
