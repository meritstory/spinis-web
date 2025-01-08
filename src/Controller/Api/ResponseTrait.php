<?php

declare(strict_types=1);

namespace App\Controller\Api;

use FOS\RestBundle\Context\Context;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    /**
     * @param string[] $serializeGroups
     */
    protected function handleResponseView(
        mixed $data,
        int $statusCode = Response::HTTP_OK,
        array $serializeGroups = []
    ): Response {
        $view = $this->view($data, $statusCode);

        if (!empty($serializeGroups)) {
            $context = new Context();
            $context->setGroups($serializeGroups);
            $view->setContext($context);
        }

        return $this->handleView($view);
    }
}
