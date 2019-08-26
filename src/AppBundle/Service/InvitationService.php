<?php

namespace AppBundle\Service;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\User;
use AppBundle\Repository\InvitationRepositoryInterface;

class InvitationService implements InvitationServiceInterface
{
    private $invitationRepository;

    public function __construct(InvitationRepositoryInterface $invitationRepository){
        $this->invitationRepository = $invitationRepository;
    }

    /**
     * @param Invitation $invitation
     * @return int
     * @throws \Exception
     */
    public function createInvitation(Invitation $invitation): int
    {
        $invitation->setStatus(Invitation::STATUS_PENDING);
        $invitation->setCreatedAt(new \DateTime());
        return $this->invitationRepository->save($invitation);
    }

    /**
     * @param User $user
     * @return array
     */
    public function listSentInvitations(User $user): array
    {
        return $this->invitationRepository->findAllSent($user);
    }

    /**
     * @param User $user
     * @return array
     */
    public function listReceivedInvitations(User $user): array
    {
        return $this->invitationRepository->findAllReceived($user->getUsername());
    }

    /**
     * @param Invitation $invitation
     * @param int $status
     */
    public function changeInvitationStatus(Invitation $invitation, int $status): void
    {
        $invitation->setStatus($status);
        $this->invitationRepository->save($invitation);
    }

}