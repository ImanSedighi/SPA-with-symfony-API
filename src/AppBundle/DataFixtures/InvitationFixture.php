<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class InvitationFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Invitation::class, 20, function (Invitation $invite) {
            $invite->setUser($this->getRandomReference(User::class));
            $invite->setReceiverUsername(($this->getRandomReference(User::class))->getUsername());
            $invite->setStatus(Invitation::STATUS_PENDING);
            $invite->setCreatedAt($this->faker->dateTimeBetween('-2 months', '-10 seconds'));
        });
        $manager->flush();
    }

    public function getDependencies()
    {
        //It makes sure when we run the Fixtures, User fixture get loaded before Invitation Fixture
        return [UserFixture::class];
    }

}