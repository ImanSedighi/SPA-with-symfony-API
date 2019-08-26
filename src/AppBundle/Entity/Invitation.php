<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="invitation")
 */
class Invitation implements \JsonSerializable
{
    // previous functions

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array(
            "id"       => $this->getId(),
            "sender" => ($this->getUser())->getUsername(),
            "receiver" => $this->getReceiverUsername(),
            "status" => $this->getStatus()
        );
    }

	const STATUS_PENDING = 0;
	const STATUS_ACCEPTED = 1;
	const STATUS_DECLINED = 2;
	const STATUS_CANCELLED = 3;

	/**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Receiver Username can't be empty.")
     */
    private $receiverUsername;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get status
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     * @param integer $status
     * @return Invitation
     */
    public function setStatus($status)
    {
        if (!in_array($status, array(self::STATUS_PENDING, self::STATUS_ACCEPTED, self::STATUS_DECLINED, self::STATUS_CANCELLED))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
        return $this;
    }

    /**
     * Get receiverUsername
     * @return string
     */
    public function getReceiverUsername()
    {
        return $this->receiverUsername;
    }

    /**
     * Set receiverUsername
     * @param $username
     * @return Invitation
     */
    public function setReceiverUsername($username)
    {
        $this->receiverUsername = $username;
        return $this;
    }

    /**
     * Get Invitation creation time
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set Invitation creation time
     * @param $createdAt
     * @return Invitation
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get senderUserId
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set senderUserId
     * @param User $user
     * @return Invitation
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    
}
