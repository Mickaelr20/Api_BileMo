<?php

// src/Security/UserVoter.php

namespace App\Security;

use App\Entity\Client;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    // Actions
    public const VIEW = 'view';
    public const DELETE = 'delete';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute is one we support and
        // $subject is App\Entity\User
        return $subject instanceof User && in_array($attribute, [self::VIEW, self::DELETE]);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $client = $token->getUser();

        if (!$client instanceof Client) {
            // the user must be logged in; if not, deny access
            return false;
        }

        return match ($attribute) {
            self::VIEW => $this->canView($client, $subject),
            self::DELETE => $this->canDelete($client, $subject),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canView(Client $client, User $user): bool
    {
        return $user->getClient() === $client;
    }

    private function canDelete(Client $client, User $user): bool
    {
        return $user->getClient() === $client;
    }
}
