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

    #[Assert\NotNull(message: 'complaint.institution.not_blank')]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?HealthCareInstitution $healthCareInstitution = null;

    #[Assert\Choice(callback: [ComplaintTypeEnum::class, 'values'], message: 'complaint.type.invalid')]
    #[ORM\Column(length: 50)]
    private string $type = ComplaintTypeEnum::PATIENT_RIGHTS->value;

    #[Assert\Choice(callback: [ComplaintStatusEnum::class, 'values'], message: 'complaint.status.invalid')]
    #[ORM\Column(length: 50)]
    private string $status = ComplaintStatusEnum::SUBMITTED->value;

    #[Assert\Choice(callback: [ComplaintTermEnum::class, 'values'], message: 'complaint.term.invalid')]
    #[ORM\Column(length: 50)]
    private string $termStatus = ComplaintTermEnum::ON_TIME->value;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Assert\Expression(
        expression: 'this.getSpecialist() === null or this.getSpecialist().isSpecialist()',
        message: 'complaint.specialist.invalid_role',
    )]
    private ?Admin $specialist = null;

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

    public function getHealthCareInstitution(): ?HealthCareInstitution
    {
        return $this->healthCareInstitution;
    }

    public function setHealthCareInstitution(?HealthCareInstitution $healthCareInstitution): static
    {
        $this->healthCareInstitution = $healthCareInstitution;

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

    public function getSpecialist(): ?Admin
    {
        return $this->specialist;
    }

    public function setSpecialist(?Admin $specialist): static
    {
        $this->specialist = $specialist;

        return $this;
    }

    public function __toString(): string
    {
        return $this->number;
    }
}
