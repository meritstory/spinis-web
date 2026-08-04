<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\ComplaintAttachmentTypeEnum;
use App\Repository\ComplaintAttachmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ComplaintAttachmentRepository::class)]
#[ORM\Table(name: 'complaint_attachment')]
class ComplaintAttachment
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'attachments')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Complaint $complaint = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?StoredFile $storedFile = null;

    #[Assert\Choice(callback: [ComplaintAttachmentTypeEnum::class, 'values'])]
    #[ORM\Column(length: 50)]
    private string $type = ComplaintAttachmentTypeEnum::INSTITUTION_SUBMISSION->value;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStoredFile(): ?StoredFile
    {
        return $this->storedFile;
    }

    public function setStoredFile(?StoredFile $storedFile): static
    {
        $this->storedFile = $storedFile;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
