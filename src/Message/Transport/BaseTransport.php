<?php

namespace App\Message\Transport;

/**
 * Class BaseTransport
 * @package App\Message\Transport
 */
abstract class BaseTransport implements TransportInterface
{
    /**
     * @param $message
     * @param $recipient
     * @return bool
     */
    public function send($message,$recipient){
        $serviceName = $this->getName();
        $path = __DIR__ . '/../../../var/messages/' . $serviceName . '/';
        $filename = $this->clean($recipient) . '_' .time() . '_' . uniqid() . '.txt';
        file_put_contents($path . $filename, $message);
        return true;
    }

    /**
     * @param $string
     * @return null|string|string[]
     */
    private function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}