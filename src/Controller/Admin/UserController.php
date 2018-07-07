<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends BaseAdminController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $user
     * @return object|void
     */
    protected function prePersistEntity($user)
    {
        if (!$user->getPassword()) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
        }

        if (!$user->getRegisteredAt()) {
            $user->setRegisteredAt(new \DateTime());
        }

        return $user;
    }

    protected function listAction()
    {
        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!$user->getisAdmin()) {
            throw $this->createAccessDeniedException();
        }

        return parent::listAction();
    }

    protected function newAction()
    {
        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!$user->getisAdmin()) {
            throw $this->createAccessDeniedException();
        }

        return parent::newAction();
    }

    protected function showAction()
    {
        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!$user->getisAdmin()) {
            throw $this->createAccessDeniedException();
        }

        return parent::showAction();
    }

    protected function editAction()
    {
        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!$user->getisAdmin()) {
            throw $this->createAccessDeniedException();
        }

        return parent::editAction();
    }

    protected function deleteAction()
    {
        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!$user->getisAdmin()) {
            throw $this->createAccessDeniedException();
        }

        return parent::deleteAction();
    }
}