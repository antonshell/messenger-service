<?php

namespace App\Message\Transport;

/**
 * Class Whatsapp
 * @package App\Message\Transport
 */
class Whatsapp extends BaseTransport implements TransportInterface
{
    /**
     * @return string
     */
    function getName()
    {
        return 'whatsapp';
    }
}