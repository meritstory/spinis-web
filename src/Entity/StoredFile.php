<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\StoredFileRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Symfony\Component\Uid\Uuid;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

#[ORM\Entity(repositoryClass: StoredFileRepository::class)]
#[ORM\Table(name: 'stored_file')]
#[ORM\Index(name: 'idx_stored_file_uploaded_by_admin', fields: ['uploadedByAdmin'])]
#[Vich\Uploadable]
class StoredFile
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private string $fileName = '';

    #[ORM\Column(length: 255)]
    private string $originalName = '';

    #[ORM\Column]
    private int $fileSize = 0;

    #[ORM\Column(length: 255)]
    private string $mimeType = 'application/octet-stream';

    #[Vich\UploadableField(
        mapping: 'files',
        fileNameProperty: 'fileName',
        size: 'fileSize',
        mimeType: 'mimeType',
        originalName: 'originalName',
    )]
    private ?SymfonyFile $uploadedFile = null;

    #[ORM\ManyToOne]
    private ?Admin $uploadedByAdmin = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): static
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): static
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    public function setFileSize(int $fileSize): static
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): static
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getUploadedByAdmin(): ?Admin
    {
        return $this->uploadedByAdmin;
    }

    public function setUploadedByAdmin(?Admin $uploadedByAdmin): static
    {
        $this->uploadedByAdmin = $uploadedByAdmin;

        return $this;
    }

    public function getUploadedFile(): ?SymfonyFile
    {
        return $this->uploadedFile;
    }

    public function setUploadedFile(?SymfonyFile $uploadedFile): static
    {
        $this->uploadedFile = $uploadedFile;

        if ($uploadedFile !== null) {
            $this->setUpdatedAt(new DateTime());
        }

        return $this;
    }
}
