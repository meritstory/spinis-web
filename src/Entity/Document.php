<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\DocumentKeyEnum;
use App\Repository\DocumentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
#[ORM\Table(name: 'document')]
#[ORM\UniqueConstraint(fields: ['key'])]
#[UniqueEntity(fields: ['key'], message: 'document.key.unique')]
class Document implements \Stringable
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'document.title.not_blank')]
    #[ORM\Column(length: 255)]
    private string $title = '';

    #[Assert\NotBlank(message: 'document.description.not_blank')]
    #[ORM\Column(type: Types::TEXT)]
    private string $description = '';

    #[Assert\Sequentially([
        new Assert\NotBlank(message: 'document.key.not_blank'),
        new Assert\Choice(callback: [DocumentKeyEnum::class, 'values'], message: 'document.key.invalid'),
    ])]
    #[ORM\Column(name: 'document_key', length: 255)]
    private string $key = '';

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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description ?? '';

        return $this;
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

    public function __toString(): string
    {
        return $this->title;
    }
}
