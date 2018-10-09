<?php

namespace App\Services\ShortLink;
use App\Entity\ShortLink;

/**
 * Clase utilizada para generar las URLs acortadas.
 */
class ShortUrlGenerator
{
    private $frontUrl;
    private $shorter;

    public function __construct($frontUrl, Shorter $shorter) {
        $this->frontUrl = $frontUrl;
        $this->shorter = $shorter;
    }

    public function shortUrl(ShortLink $shortLink) {
        return $this->frontUrl.$this->shorter->getShorterUrl($shortLink->getId());
    }
}