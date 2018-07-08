<?php

namespace App\Repository;

use App\Entity\ShortLink;
use Doctrine\ORM\EntityRepository;

class ShortLinkRepository extends EntityRepository
{
    public function findExistentUrl(ShortLink $shortLink) {
        $qb = $this->createQueryBuilder('sl')
            ->andWhere('sl.url = :url')
            ->setParameter('url', $shortLink->getUrl());

        if ($shortLink->getId()) {
            $qb
                ->andWhere('sl.id <> :id')
                ->setParameter('id', $shortLink->getId());
        }

        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }
}