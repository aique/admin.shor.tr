<?php

namespace App\Controller\Admin;

use App\Entity\ShortLink;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class ShortLinkController extends BaseAdminController
{
    /**
     * @param ShortLink $shortLink
     * @return mixed|void
     */
    protected function prePersistEntity($shortLink)
    {
        if (!$shortLink->getUser()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $shortLink->setUser($user);
        }

        return $shortLink;
    }

    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $query = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!$user->getisAdmin()) {
            $query
                ->andWhere('entity.user = :user')
                ->setParameter('user', $user);
        }

        return $query;
    }

    protected function newAction()
    {
        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($user->getisAdmin()) {
            return $this->redirectToRoute('dashboard');
        }

        return parent::newAction();
    }

    protected function editAction()
    {
        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($user->getisAdmin()) {
            return $this->redirectToRoute('dashboard');
        }

        return parent::editAction();
    }
}