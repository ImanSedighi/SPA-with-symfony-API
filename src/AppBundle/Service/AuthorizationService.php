<?php

namespace AppBundle\Service;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\User;
use AppBundle\Repository\InvitationRepositoryInterface;
use Psr\Log\NullLogger;

class AuthorizationService implements AuthorizationServiceInterface
{
    /**
     * @var InvitationRepositoryInterface
     */
    private $invitationRepository;

    public function __construct(InvitationRepositoryInterface $invitationRepository){
        $this->invitationRepository = $invitationRepository;
    }

    /**
     * @param User $user
     * @param int $id
     * @return Invitation
     */
    public function canRespondToInvitation(User $user, int $id): Invitation
    {
        $invitation =  $this->invitationRepository->findById($id);
        if ($user->getUsername() !== $invitation->getReceiverUsername()) {
            return NULL;
        }
        return $invitation;
    }

    /**
     * @param User $user
     * @param int $id
     * @return Invitation
     */
    public function canDeleteInvitation(User $user, int $id): Invitation
    {
        $invitation =  $this->invitationRepository->findById($id);
        if ($user->getId() !== ($invitation->getUser())->getId()) {
            return Null;
        }
        return $invitation;
    }
}