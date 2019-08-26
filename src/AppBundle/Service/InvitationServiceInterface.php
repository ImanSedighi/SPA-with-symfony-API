<?php

namespace AppBundle\Service;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\User;

interface InvitationServiceInterface
{
    public function createInvitation(Invitation $invitation): int;

    public function listSentInvitations(User $user): array;

    public function listReceivedInvitations(User $user): array;

    public function changeInvitationStatus(Invitation $invitation, int $status): void;

}