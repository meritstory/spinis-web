<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\StoredFile;
use App\Security\Voter\StoredFileVoter;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;

final class StoredFileController extends AbstractController
{
    public function __construct(
        #[Target('s3.storage')]
        private readonly FilesystemOperator $storage,
    ) {
    }

    #[Route('/files/{uuid}', name: 'file_s3', methods: [Request::METHOD_GET])]
    public function __invoke(
        #[MapEntity(expr: 'repository.findOneBy({id: uuid})')]
        StoredFile $file,
    ): Response {
        $this->denyAccessUnlessGranted(StoredFileVoter::VIEW, $file);

        try {
            $stream = $this->storage->readStream($file->getFileName());
        } catch (FilesystemException) {
            throw $this->createNotFoundException();
        }

        $downloadName = $this->dispositionFilename($file->getOriginalName(), $file->getFileName());
        $fallbackName = $this->dispositionFallbackFilename($file->getFileName());

        $response = new StreamedResponse(static function () use ($stream): void {
            try {
                fpassthru($stream);
            } finally {
                fclose($stream);
            }
        });
        $response->headers->set('Content-Type', $file->getMimeType());
        $response->headers->set('Cache-Control', 'private, no-store');
        $response->headers->set(
            'Content-Disposition',
            $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                $downloadName,
                $fallbackName,
            ),
        );

        return $response;
    }

    private function dispositionFilename(string $originalName, string $storagePath): string
    {
        $name = trim($originalName);
        if ($name === '') {
            $name = basename(str_replace('\\', '/', $storagePath));
        }

        return $this->stripPathSeparators($name);
    }

    private function dispositionFallbackFilename(string $storagePath): string
    {
        return $this->stripPathSeparators(basename(str_replace('\\', '/', $storagePath)));
    }

    private function stripPathSeparators(string $filename): string
    {
        $filename = str_replace(['/', '\\'], '-', $filename);

        return trim($filename) !== '' ? trim($filename) : 'download';
    }
}
