<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\User;

interface InvitationRepositoryInterface
{
    public function findById(int $inviteId): Invitation;

    public function findAllSent(User $user): array;

    public function findAllReceived(string $username): array;

    public function save(Invitation $invitation): int;
}