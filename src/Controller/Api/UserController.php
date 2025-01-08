<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\User;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OAT;

/**
 * @method User getUser()
 */
#[Route('/api/users')]
#[OAT\Tag(name: 'Users')]
class UserController extends AbstractFOSRestController
{
    use ResponseTrait;

    #[Route('/me', methods: [Request::METHOD_GET])]
    #[OAT\Response(
        response: Response::HTTP_OK,
        description: 'Returns the current user',
        content: new OAT\JsonContent(ref: new Model(type: User::class, groups: ['me']))
    )]
    public function me(): Response
    {
        return $this->handleResponseView($this->getUser(), serializeGroups: ['me']);
    }
}
