<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\ComplaintStatusEnum;
use App\Enum\ComplaintTermEnum;
use App\Enum\ComplaintTypeEnum;
use App\Repository\ComplaintRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ComplaintRepository::class)]
#[ORM\Table(name: 'complaint')]
#[ORM\UniqueConstraint(fields: ['number'])]
#[UniqueEntity(fields: ['number'], message: 'complaint.number.unique')]
class Complaint implements \Stringable
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'complaint.number.not_blank')]
    #[ORM\Column(length: 50)]
    private string $number = '';

    #[Assert\NotBlank(message: 'complaint.institution.not_blank')]
    #[ORM\Column(length: 255)]
    private string $institutionName = '';

    #[Assert\Choice(callback: [ComplaintTypeEnum::class, 'values'], message: 'complaint.type.invalid')]
    #[ORM\Column(length: 50)]
    private string $type = ComplaintTypeEnum::PATIENT_RIGHTS->value;

    #[Assert\Choice(callback: [ComplaintStatusEnum::class, 'values'], message: 'complaint.status.invalid')]
    #[ORM\Column(length: 50)]
    private string $status = ComplaintStatusEnum::SUBMITTED->value;

    #[Assert\Choice(callback: [ComplaintTermEnum::class, 'values'], message: 'complaint.term.invalid')]
    #[ORM\Column(length: 50)]
    private string $termStatus = ComplaintTermEnum::ON_TIME->value;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $specialist = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getInstitutionName(): string
    {
        return $this->institutionName;
    }

    public function setInstitutionName(string $institutionName): static
    {
        $this->institutionName = $institutionName;

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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTermStatus(): string
    {
        return $this->termStatus;
    }

    public function setTermStatus(string $termStatus): static
    {
        $this->termStatus = $termStatus;

        return $this;
    }

    public function getSpecialist(): ?string
    {
        return $this->specialist;
    }

    public function setSpecialist(?string $specialist): static
    {
        $this->specialist = $specialist;

        return $this;
    }

    public function __toString(): string
    {
        return $this->number;
    }
}
