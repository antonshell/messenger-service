<?php

namespace App\Tests\Message\Transport;

use App\Message\Transport\Telegram;
use PHPUnit\Framework\TestCase;

class TelegramTest extends TestCase
{
    public function testGetName()
    {
        $transport = new Telegram();
        $this->assertEquals('telegram', $transport->getName());
    }
}