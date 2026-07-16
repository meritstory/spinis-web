<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SettingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SettingRepository::class)]
#[ORM\Table(name: 'setting')]
#[ORM\UniqueConstraint(fields: ['key'])]
#[UniqueEntity(fields: ['key'], message: 'setting.key.unique')]
class Setting implements \Stringable
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'setting.key.not_blank')]
    #[ORM\Column(name: 'setting_key', length: 255)]
    private string $key = '';

    #[Assert\NotBlank(message: 'setting.value.not_blank')]
    #[ORM\Column(type: Types::TEXT)]
    private string $value = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(?string $key): static
    {
        $this->key = $key ?? '';

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(?string $value): static
    {
        $this->value = $value ?? '';

        return $this;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
