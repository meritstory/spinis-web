<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\ComplaintStatusEnum;
use App\Enum\ComplaintTermEnum;
use App\Enum\ComplaintTypeEnum;
use App\Repository\ComplaintRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[Assert\GreaterThanOrEqual('today', message: 'complaint.term_date.not_in_past')]
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $termDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $complaintDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $eventDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $relatedSpecialists = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $complaintDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $disagreementDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $expectedResult = null;

    #[ORM\Column(options: ['default' => false])]
    private bool $submittedByRepresentative = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Complainant $patient = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Complainant $representative = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Assert\Expression(
        expression: 'this.getSpecialist() === null or this.getSpecialist().isAssignableAsComplaintSpecialist()',
        message: 'complaint.specialist.invalid_role',
    )]
    private ?Admin $specialist = null;

    /**
     * @var Collection<int, ComplaintAttachment>
     */
    #[ORM\OneToMany(mappedBy: 'complaint', targetEntity: ComplaintAttachment::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $attachments;

    /**
     * @var Collection<int, ComplaintStatusHistory>
     */
    #[ORM\OneToMany(mappedBy: 'complaint', targetEntity: ComplaintStatusHistory::class, cascade: ['persist'], orphanRemoval: true)]
    #[ORM\OrderBy(['changedAt' => 'ASC'])]
    private Collection $statusHistory;

    public function __construct()
    {
        $this->attachments = new ArrayCollection();
        $this->statusHistory = new ArrayCollection();
    }

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

    public function getTermDate(): ?\DateTimeImmutable
    {
        return $this->termDate;
    }

    public function setTermDate(?\DateTimeImmutable $termDate): static
    {
        $this->termDate = $termDate;

        return $this;
    }

    public function getComplaintDate(): ?\DateTimeImmutable
    {
        return $this->complaintDate;
    }

    public function setComplaintDate(?\DateTimeImmutable $complaintDate): static
    {
        $this->complaintDate = $complaintDate;

        return $this;
    }

    public function getEventDate(): ?\DateTimeImmutable
    {
        return $this->eventDate;
    }

    public function setEventDate(?\DateTimeImmutable $eventDate): static
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getRelatedSpecialists(): ?string
    {
        return $this->relatedSpecialists;
    }

    public function setRelatedSpecialists(?string $relatedSpecialists): static
    {
        $this->relatedSpecialists = $relatedSpecialists;

        return $this;
    }

    public function getComplaintDescription(): ?string
    {
        return $this->complaintDescription;
    }

    public function setComplaintDescription(?string $complaintDescription): static
    {
        $this->complaintDescription = $complaintDescription;

        return $this;
    }

    public function getDisagreementDescription(): ?string
    {
        return $this->disagreementDescription;
    }

    public function setDisagreementDescription(?string $disagreementDescription): static
    {
        $this->disagreementDescription = $disagreementDescription;

        return $this;
    }

    public function getExpectedResult(): ?string
    {
        return $this->expectedResult;
    }

    public function setExpectedResult(?string $expectedResult): static
    {
        $this->expectedResult = $expectedResult;

        return $this;
    }

    public function isSubmittedByRepresentative(): bool
    {
        return $this->submittedByRepresentative;
    }

    public function setSubmittedByRepresentative(bool $submittedByRepresentative): static
    {
        $this->submittedByRepresentative = $submittedByRepresentative;

        return $this;
    }

    public function getPatient(): ?Complainant
    {
        return $this->patient;
    }

    public function setPatient(?Complainant $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getRepresentative(): ?Complainant
    {
        return $this->representative;
    }

    public function setRepresentative(?Complainant $representative): static
    {
        $this->representative = $representative;

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

    /**
     * @return Collection<int, ComplaintAttachment>
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(ComplaintAttachment $attachment): static
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments->add($attachment);
            $attachment->setComplaint($this);
        }

        return $this;
    }

    public function removeAttachment(ComplaintAttachment $attachment): static
    {
        if ($this->attachments->removeElement($attachment) && $attachment->getComplaint() === $this) {
            $attachment->setComplaint(null);
        }

        return $this;
    }

    /**
     * @return Collection<int, ComplaintStatusHistory>
     */
    public function getStatusHistory(): Collection
    {
        return $this->statusHistory;
    }

    public function addStatusHistory(ComplaintStatusHistory $statusHistory): static
    {
        if (!$this->statusHistory->contains($statusHistory)) {
            $this->statusHistory->add($statusHistory);
            $statusHistory->setComplaint($this);
        }

        return $this;
    }

    public function removeStatusHistory(ComplaintStatusHistory $statusHistory): static
    {
        if ($this->statusHistory->removeElement($statusHistory) && $statusHistory->getComplaint() === $this) {
            $statusHistory->setComplaint(null);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->number;
    }
}
