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

    public function getShorterUrl($id) {
        if ($this->isWrongId($id)) {
            throw new WrongIdShorterException();
        }

        if ($id == 0) {
            return substr(self::URL_CHARS, 0, 1);
        }

        return $this->calculateShorterUrl($id);
    }

    private function isWrongId($id) {
        return !preg_match('/^[0-9]+$/', $id) || $id < 0;
    }

    private function calculateShorterUrl($id) {
        $url = '';

        $base = strlen(self::URL_CHARS);

        while ($id > 0) {
            $url .= substr(self::URL_CHARS, $id % $base, 1);
            $id = floor($id / $base);
        }

        return strrev($url);
    }

    public function getShorterId($url) {
        if ($this->isWrongUrl($url)) {
            throw new WrongUrlShorterException();
        }

        return $this->calculateShorterId($url);
    }

    private function isWrongUrl($url) {
        return !preg_match('/^[a-zA-Z0-9]+$/', $url);
    }

    private function calculateShorterId($url) {
        $id = 0;

        $base = strlen(self::URL_CHARS);
        $urlLength = strlen($url);

        for ($i = 0 ; $i < $urlLength ; $i++) {
            $urlChar = substr($url, $i, 1);
            $id = ($id * $base) + strpos(self::URL_CHARS, $urlChar);
        }

        return $id;
    }
}