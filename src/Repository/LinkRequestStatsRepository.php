<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class LinkRequestStatsRepository extends EntityRepository
{
    public function findLastShortLinkStats($shortLinkId, $numItems) {
        return $this->createQueryBuilder('lrs')
            ->andWhere('lrs.shortLink = :short_link')
            ->setParameter('short_link', $shortLinkId)
            ->setMaxResults($numItems)
            ->orderBy('lrs.createdAt', 'desc')
            ->getQuery()
            ->getResult();
    }
}