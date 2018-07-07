<?php

namespace App\Entity;

use App\Services\ShortLink\Shorter;
use App\Services\ShortLink\ShortUrlHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class ShortLink
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\Url()
     * @ORM\Column(name="url", type="text")
     */
    private $url; // TODO validar que la url no exista previamente

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="shortLinks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * Atributo adicional creado para que el admin pueda mostrarlo en sus listados.
     *
     * @var string
     */
    private $shortUrl;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getShortUrl()
    {
        return $this;
    }

    public function __toString()
    {
        return strval($this->getUrl());
    }
}