<?php

namespace App\Services\ShortLink;

/**
 * Esta clase es la encargada de generar la cadena
 * abreviada que sustituirá al enlace.
 *
 * A su vez también traducirá esta cadena a un número
 * entero que será utilizado como id en la base de datos
 * del link abreviado, con el fin de optimizar búsquedas.
 */
class Shorter
{
    const URL_CHARS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    private $base;

    public function __construct()
    {
        $this->base = strlen(self::URL_CHARS);
    }

    public function getShorterUrl($id)
    {
        if (!preg_match('/^[0-9]+$/', $id)) {
            throw new WrongIdShorterException();
        }

        if ($id < 0) {
            throw new WrongIdShorterException();
        }

        if ($id == 0) {
            return substr(self::URL_CHARS, 0, 1);
        }

        $url = '';

        while ($id > 0) {
            $url .= substr(self::URL_CHARS, $id % $this->base, 1);
            $id = floor($id / $this->base);
        }

        return strrev($url);
    }

    public function getShorterId($url)
    {
        if (!preg_match('/^[a-zA-Z0-9]+$/', $url)) {
            throw new WrongUrlShorterException();
        }

        $id = 0;

        $urlLength = strlen($url);

        for ($i = 0 ; $i < $urlLength ; $i++) {
            $urlChar = substr($url, $i, 1);
            $id = ($id * $this->base) + strpos(self::URL_CHARS, $urlChar);
        }

        return $id;
    }
}