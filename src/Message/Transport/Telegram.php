<?php

namespace App\Message\Transport;

/**
 * Class Telegram
 * @package App\Message\Transport
 */
class Telegram extends BaseTransport implements TransportInterface
{
    /**
     * @return string
     */
    function getName()
    {
        return 'telegram';
    }
}