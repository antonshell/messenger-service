<?php

namespace App\Message\Transport;

/**
 * Class Viber
 * @package App\Message\Transport
 */
class Viber extends BaseTransport implements TransportInterface
{
    /**
     * @return string
     */
    function getName()
    {
        return 'viber';
    }

    /**
     * @param $message
     * @param $recipient
     * @return bool
     */
    public function send($message,$recipient){

        $success = (rand(1,3) == 3);

        if(!$success){
            return false;
        }

        return parent::send($message,$recipient);
    }
}