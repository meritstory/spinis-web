<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\ComplaintAttachmentTypeEnum;
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

    #[ORM\ManyToOne(inversedBy: 'attachments')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Complaint $complaint = null;

    #[ORM\Column(length: 50, nullable: true, enumType: ComplaintAttachmentTypeEnum::class)]
    private ?ComplaintAttachmentTypeEnum $type = null;

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

    public function getFormattedFileSize(): string
    {
        $bytes = $this->fileSize;
        if ($bytes < 1024) {
            return sprintf('%d B', $bytes);
        }

        if ($bytes < 1024 * 1024) {
            return sprintf('%.1f KB', $bytes / 1024);
        }

        return sprintf('%.1f MB', $bytes / (1024 * 1024));
    }

    public function getDisplayFileType(): string
    {
        return match ($this->mimeType) {
            'application/pdf' => 'PDF',
            'application/msword' => 'DOC',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'DOCX',
            'application/vnd.ms-excel' => 'XLS',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'XLSX',
            'image/jpeg' => 'JPEG',
            'image/png' => 'PNG',
            default => $this->displayFileTypeFromExtension(),
        };
    }

    private function displayFileTypeFromExtension(): string
    {
        $extension = pathinfo($this->originalName, PATHINFO_EXTENSION);
        if ($extension === '') {
            $extension = pathinfo($this->fileName, PATHINFO_EXTENSION);
        }

        return $extension !== '' ? strtoupper($extension) : 'FILE';
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

    public function getComplaint(): ?Complaint
    {
        return $this->complaint;
    }

    public function setComplaint(?Complaint $complaint): static
    {
        $this->complaint = $complaint;

        return $this;
    }

    public function getType(): ?ComplaintAttachmentTypeEnum
    {
        return $this->type;
    }

    public function setType(?ComplaintAttachmentTypeEnum $type): static
    {
        $this->type = $type;

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
