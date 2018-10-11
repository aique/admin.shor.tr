<?php

namespace App\Tests\Utils;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserGenerator {

    const USERNAME = 'aique';
    const EMAIL = 'aique@mail.com';
    const PASSWORD = 'aique';

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function createTestUser() {
        $user = new User(
            self::USERNAME,
            self::EMAIL,
            self::PASSWORD
        );

        $user->setRegisteredAt(new \DateTime());
        $user->setIsAdmin(false);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));

        return $user;
    }
}