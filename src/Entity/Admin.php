<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AdminRepository;
use App\Security\AdminAuthCode;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: '`admin`')]
#[ORM\UniqueConstraint(fields: ['email'])]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface, TwoFactorInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $firstName = '';

    #[ORM\Column(length: 255)]
    private string $lastName = '';

    #[Groups(['me'])]
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var string[]
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(options: ['default' => true])]
    private bool $active = true;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $lastActiveAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $authCode = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $authCodeExpiresAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        /** @var non-empty-string $userIdentifier */
        $userIdentifier = $this->email;

        return $userIdentifier;
    }

    /**
     * @see UserInterface
     *
     * @return string[]
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = RoleEnum::USER->value;

        return array_unique($roles);
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getLastActiveAt(): ?\DateTimeImmutable
    {
        return $this->lastActiveAt;
    }

    public function setLastActiveAt(?\DateTimeImmutable $lastActiveAt): static
    {
        $this->lastActiveAt = $lastActiveAt;

        return $this;
    }

    public function getAuthCode(): ?string
    {
        return $this->authCode;
    }

    public function setAuthCode(?string $authCode): static
    {
        $this->authCode = $authCode;

        if ($authCode === null) {
            $this->authCodeExpiresAt = null;
        }

        return $this;
    }

    public function getAuthCodeExpiresAt(): ?\DateTimeImmutable
    {
        return $this->authCodeExpiresAt;
    }

    public function setAuthCodeExpiresAt(?\DateTimeImmutable $authCodeExpiresAt): static
    {
        $this->authCodeExpiresAt = $authCodeExpiresAt;

        return $this;
    }

    public function isAuthCodeExpired(): bool
    {
        return $this->authCodeExpiresAt !== null
            && $this->authCodeExpiresAt < new \DateTimeImmutable();
    }

    public function isEmailAuthEnabled(): bool
    {
        return $this->isActive();
    }

    public function getEmailAuthRecipient(): string
    {
        /** @var non-empty-string $email */
        $email = $this->email;

        return $email;
    }

    public function getEmailAuthCode(): ?string
    {
        return $this->authCode;
    }

    public function setEmailAuthCode(string $authCode): void
    {
        $this->authCode = $authCode;
        $this->authCodeExpiresAt = new \DateTimeImmutable(AdminAuthCode::EXPIRES_AFTER);
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
    }
}
