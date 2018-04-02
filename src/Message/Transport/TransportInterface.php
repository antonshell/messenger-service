<?php

namespace App\Message\Transport;

/**
 * Interface TransportInterface
 * @package App\Message\Transport
 */
interface TransportInterface
{
    /**
     * @param $message
     * @param $recipient
     * @return bool
     */
    public function send($message, $recipient);

    /**
     * @return string
     */
    public function getName();
}