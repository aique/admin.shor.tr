<?php

namespace App\Services\Validation;

use App\Entity\User;

class UserValidator
{
    const MIN_USERNAME_LENGTH = 5;
    const MAX_USERNAME_LENGTH = 25;

    const MIN_PASS_LENGTH = 5;
    const MAX_PASS_LENGTH = 25;

    /**
     * @var User
     */
    private $user;

    public function __construct($user = null) {
        $this->user = $user;
    }

    public function validate($user = null) {

        if (!$user) {
            $user = $this->user;
        }

        return $this->validateUsername($user->getUsername())
            && $this->validateEmail($user->getEmail())
            && $this->validatePassword($user->getPlainPassword());
    }

    private function validateUsername($username) {
        if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
            return false;
        }

        if (strlen($username) < self::MIN_USERNAME_LENGTH || strlen($username) > self::MAX_USERNAME_LENGTH) {
            return false;
        }

        return true;
    }

    private function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function validatePassword($username) {
        if (strlen($username) < self::MIN_PASS_LENGTH || strlen($username) > self::MAX_PASS_LENGTH) {
            return false;
        }

        return true;
    }
}