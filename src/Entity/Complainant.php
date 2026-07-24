<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ComplainantRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ComplainantRepository::class)]
#[ORM\Table(name: 'complainant')]
#[ORM\UniqueConstraint(fields: ['personalCode'])]
#[UniqueEntity(fields: ['personalCode'], message: 'complainant.personal_code.unique')]
class Complainant implements UserInterface, \Stringable
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private bool $legalEntity = false;

    #[Assert\NotBlank(message: 'complainant.personal_code.not_blank')]
    #[ORM\Column(type: 'encrypted_personal_code')]
    private string $personalCode = '';

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $companyCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $companyName = null;

    #[Assert\NotBlank(message: 'complainant.first_name.not_blank')]
    #[ORM\Column(length: 100)]
    private string $firstName = '';

    #[Assert\NotBlank(message: 'complainant.last_name.not_blank')]
    #[ORM\Column(length: 100)]
    private string $lastName = '';

    #[ORM\Column(length: 255)]
    private string $email = '';

    #[ORM\Column(length: 50)]
    private string $phone = '';

    #[ORM\Column(length: 255)]
    private string $address = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isLegalEntity(): bool
    {
        return $this->legalEntity;
    }

    public function setLegalEntity(bool $legalEntity): static
    {
        $this->legalEntity = $legalEntity;

        return $this;
    }

    public function getPersonalCode(): string
    {
        return $this->personalCode;
    }

    public function setPersonalCode(string $personalCode): static
    {
        $this->personalCode = $personalCode;

        return $this;
    }

    public function getCompanyCode(): ?string
    {
        return $this->companyCode;
    }

    public function setCompanyCode(?string $companyCode): static
    {
        $this->companyCode = $companyCode;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->requirePersonalCode();
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return [RoleEnum::COMPLAINANT->value];
    }

    public function eraseCredentials(): void
    {
    }

    public function __toString(): string
    {
        $name = trim($this->firstName.' '.$this->lastName);

        return $name !== '' ? $name : $this->personalCode;
    }

    /**
     * @return non-empty-string
     */
    private function requirePersonalCode(): string
    {
        if ($this->personalCode === '') {
            throw new \LogicException('Complainant personal code is not set.');
        }

        /** @var non-empty-string $personalCode */
        $personalCode = $this->personalCode;

        return $personalCode;
    }
}
