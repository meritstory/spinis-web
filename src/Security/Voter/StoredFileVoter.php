<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Admin;
use App\Entity\RoleEnum;
use App\Entity\StoredFile;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * @extends Voter<string, StoredFile>
 */
final class StoredFileVoter extends Voter
{
    public const string VIEW = 'VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::VIEW && $subject instanceof StoredFile;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof Admin) {
            return false;
        }

        $storedFile = $subject;
        $uploadedBy = $storedFile->getUploadedByAdmin();

        if ($uploadedBy !== null && $uploadedBy->getId() === $user->getId()) {
            return true;
        }

        return $storedFile->getComplaint() !== null
            && in_array(RoleEnum::DEPARTMENT_HEAD->value, $user->getRoles(), true);
    }
}
