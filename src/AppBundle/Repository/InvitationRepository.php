<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class InvitationRepository implements InvitationRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ObjectRepository
     */
    private $objectRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        //parent::__construct($entityManager, Invitation::class);
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(Invitation::class);
    }

    /**
     * @param Invitation $invitation
     * @return int
     */
    public function save(Invitation $invitation): int
    {
        $this->entityManager->persist($invitation);
        $this->entityManager->flush();
        return $invitation->getId();
    }

    /**
     * @param int $inviteId
     * @return Invitation
     */
    public function findById(int $inviteId): Invitation
    {
        return $this->objectRepository->find($inviteId);
    }

    /**
     * @param User $sender
     * @return array
     */
    public function findAllSent(User $sender): array
    {
        return $this->objectRepository->findBy(['user'=>$sender]);
    }

    /**
     * @param string $username
     * @return array
     */
    public function findAllReceived(string $username): array
    {
        return $this->objectRepository->findBy(array('receiverUsername'=>$username));
    }

}