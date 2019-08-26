<?php

namespace AppBundle\Service;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\User;

interface AuthorizationServiceInterface
{
    public function canRespondToInvitation(User $user, int $id): Invitation;

    public function canDeleteInvitation(User $user, int $id): Invitation;
}