<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 5, function (User $user) {
            $user->setUsername("username".$this->faker->unique()->randomNumber(3));
            $user->setEmail($this->faker->email());
            $user->setPassword('$2y$13$IL.n9khi/s6lE4MQNFIbl.1XYj2t4oRCv3z3.yWgfvO1EzelExmaK');
            $user->setEnabled(true);
        });
        $manager->flush();
    }

}