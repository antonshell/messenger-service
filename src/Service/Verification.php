<?php

namespace App\Service;

use App\Message\Transport\Telegram;
use App\Message\Transport\Viber;
use App\Message\Transport\WhatsApp;
use App\Queue\QueueManager;

/**
 * Class Verification
 * @package App\Service
 */
class Verification
{
    private $tokens = [
        'KpRpTd6MUt9nXruK',
    ];

    /**
     * @TODO implement more advanced verification
     *
     * @param $token
     * @return bool
     */
    public function verifyToken($token){
        return in_array($token,$this->tokens);
    }
}