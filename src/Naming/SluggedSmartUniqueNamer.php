<?php

declare(strict_types=1);

namespace App\Naming;

use App\Entity\StoredFile;
use LogicException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Uid\Ulid;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

/** @implements NamerInterface<StoredFile> */
final readonly class SluggedSmartUniqueNamer implements NamerInterface
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function name(object $object, PropertyMapping $mapping): string
    {
        $file = $mapping->getFile($object);

        if (!$file instanceof UploadedFile) {
            throw new LogicException('The uploaded file is missing.');
        }

        $originalName = $file->getClientOriginalName();
        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $slug = $this->slugger->slug($baseName)->lower()->toString();
        $slug = $slug !== '' ? $slug : 'file';
        $extension = $file->getClientOriginalExtension();
        $suffix = (string) new Ulid();

        return $extension !== ''
            ? sprintf('%s-%s.%s', $slug, $suffix, strtolower($extension))
            : sprintf('%s-%s', $slug, $suffix);
    }
}
