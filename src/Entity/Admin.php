<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AdminRepository;
use App\Security\AdminAuthCode;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: '`admin`')]
#[ORM\UniqueConstraint(fields: ['email'])]
#[UniqueEntity(
    fields: ['email'],
    repositoryMethod: 'findOneByEmailForUniqueValidation',
    message: 'admin.error.email_unique',
)]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface, TwoFactorInterface, EquatableInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'admin.error.first_name_required')]
    private string $firstName = '';

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'admin.error.last_name_required')]
    private string $lastName = '';

    #[Groups(['me'])]
    #[ORM\Column(length: 180)]
    #[Assert\Sequentially([
        new Assert\NotBlank(message: 'admin.error.email_required'),
        new Assert\Email(message: 'admin.error.email_invalid'),
    ])]
    private string $email = '';

    /**
     * @var string[]
     */
    #[ORM\Column(options: ['jsonb' => true])]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(options: ['default' => true])]
    private bool $active = true;

    #[ORM\Column(options: ['default' => true])]
    private bool $emailTwoFactorEnabled = true;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $lastActiveAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $authCode = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $authCodeExpiresAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = mb_strtolower(trim($email));

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->requireEmail();
    }

    /**
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
        $roles = array_values(array_unique(array_filter(
            $roles,
            static fn (string $role): bool => $role !== RoleEnum::USER->value,
        )));

        if (count($roles) > 1) {
            throw new \InvalidArgumentException('An admin account can have only one administrative role.');
        }

        $this->roles = $roles;

        return $this;
    }

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

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
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

    public function isEmailTwoFactorEnabled(): bool
    {
        return $this->emailTwoFactorEnabled;
    }

    public function setEmailTwoFactorEnabled(bool $emailTwoFactorEnabled): static
    {
        $this->emailTwoFactorEnabled = $emailTwoFactorEnabled;

        return $this;
    }

    public function isEmailAuthEnabled(): bool
    {
        return $this->isActive() && $this->emailTwoFactorEnabled;
    }

    public function getDisplayName(): string
    {
        $name = trim($this->firstName.' '.$this->lastName);

        return $name !== '' ? $name : $this->requireEmail();
    }

    public function getPrimaryRole(): ?RoleEnum
    {
        foreach ($this->roles as $role) {
            $roleEnum = RoleEnum::tryFromAdminRole($role);

            if ($roleEnum !== null) {
                return $roleEnum;
            }
        }

        return null;
    }

    public function getRoleLabel(): string
    {
        $role = $this->getPrimaryRole();

        return $role !== null ? $role->value : '';
    }

    public function getEmailAuthRecipient(): string
    {
        return $this->requireEmail();
    }

    /**
     * @return non-empty-string
     */
    private function requireEmail(): string
    {
        if ($this->email === '') {
            throw new \LogicException('Admin email is not set.');
        }

        /** @var non-empty-string $email */
        $email = $this->email;

        return $email;
    }

    public function getEmailAuthCode(): ?string
    {
        return $this->authCode;
    }

    public function isEqualTo(UserInterface $user): bool
    {
        return $user instanceof self
            && $this->id === $user->id
            && $this->email === $user->email
            && $this->password === $user->password
            && $this->roles === $user->roles
            && $this->active === $user->active
            && $this->emailTwoFactorEnabled === $user->emailTwoFactorEnabled
            && $this->deletedAt?->getTimestamp() === $user->deletedAt?->getTimestamp();
    }

    public function setEmailAuthCode(string $authCode): void
    {
        $this->authCode = $authCode;
        $this->authCodeExpiresAt = new \DateTimeImmutable(AdminAuthCode::EXPIRES_AFTER);
    }

    public function eraseCredentials(): void
    {
    }
}
