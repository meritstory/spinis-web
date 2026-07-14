<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LinkRepository::class)]
#[ORM\Table(name: 'link')]
#[ORM\UniqueConstraint(fields: ['key'])]
#[UniqueEntity(fields: ['key'], message: 'link.key.unique')]
class Link
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'link.title.not_blank')]
    #[ORM\Column(length: 255)]
    private string $title = '';

    #[Assert\NotBlank(message: 'link.key.not_blank')]
    #[ORM\Column(name: 'link_key', length: 255)]
    private string $key = '';

    #[Assert\NotBlank(message: 'link.url.not_blank')]
    #[Assert\Url(message: 'link.url.invalid')]
    #[ORM\Column(length: 2048)]
    private string $url = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
