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
    public function getShorterUrl()
    {

    }

    public function getShorterId()
    {
        return 1;
    }
}