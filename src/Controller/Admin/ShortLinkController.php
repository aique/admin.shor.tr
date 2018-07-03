<?php

namespace App\Controller\Admin;

use App\Entity\ShortLink;
use App\Services\ShortLink\Shorter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class ShortLinkController extends BaseAdminController
{
    private $shorter;

    public function __construct(Shorter $shorter)
    {
        $this->shorter = $shorter;
    }

    protected function createNewEntity()
    {
        /** @var ShortLink $entity */
        $entity = parent::createNewEntity();
        $entity->setId($this->shorter->getShorterId());

        return $entity;
    }
}