<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\HealthCareInstitutionRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: HealthCareInstitutionRepository::class)]
#[ORM\Table(name: 'health_care_institution')]
#[ORM\UniqueConstraint(fields: ['code'])]
#[UniqueEntity(fields: ['code'])]
class HealthCareInstitution implements \Stringable
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column]
    private int $code;

    #[ORM\Column]
    private bool $licensed = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title ?? '';

        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function isLicensed(): bool
    {
        return $this->licensed;
    }

    public function setLicensed(bool $licensed): static
    {
        $this->licensed = $licensed;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
