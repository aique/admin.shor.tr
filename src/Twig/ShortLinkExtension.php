<?php

namespace App\Twig;

use App\Entity\ShortLink;
use App\Services\ShortLink\ShortUrlGenerator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ShortLinkExtension extends AbstractExtension
{
    private $shortUrlHelper;

    public function __construct(ShortUrlGenerator $shortUrlHelper)
    {
        $this->shortUrlHelper = $shortUrlHelper;
    }

    public function getFilters()
    {
        return array(
            new TwigFilter('short_url', array($this, 'shortUrlFilter')),
        );
    }

    public function shortUrlFilter(ShortLink $shortLink)
    {
        return $this->shortUrlHelper->shortUrl($shortLink);
    }
}