<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ComplaintPatientRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ComplaintPatientRepository::class)]
#[ORM\Table(name: 'complaint_patient')]
class ComplaintPatient
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'patient', targetEntity: Complaint::class)]
    #[ORM\JoinColumn(nullable: false, unique: true, onDelete: 'CASCADE')]
    private ?Complaint $complaint = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Complainant $complainant = null;

    #[ORM\Column(length: 100, nullable: true, options: ['collation' => 'lt_alphabet'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 100, nullable: true, options: ['collation' => 'lt_alphabet'])]
    private ?string $lastName = null;

    #[ORM\Column(type: 'encrypted_personal_code', nullable: true)]
    private ?string $personalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

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

    public function getComplainant(): ?Complainant
    {
        return $this->complainant;
    }

    public function setComplainant(?Complainant $complainant): static
    {
        $this->complainant = $complainant;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPersonalCode(): ?string
    {
        return $this->personalCode;
    }

    public function setPersonalCode(?string $personalCode): static
    {
        $this->personalCode = $personalCode;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function copyFromComplainant(Complainant $complainant, bool $linkComplainant = true): static
    {
        if ($linkComplainant) {
            $this->complainant = $complainant;
        }

        $this->firstName = $complainant->getFirstName();
        $this->lastName = $complainant->getLastName();
        $this->personalCode = $complainant->getPersonalCode();
        $this->address = $complainant->getAddress();
        $this->phone = $complainant->getPhone();
        $this->email = $complainant->getEmail();

        return $this;
    }
}
