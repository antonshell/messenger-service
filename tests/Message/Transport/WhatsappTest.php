<?php

namespace App\Tests\Message\Transport;

use App\Message\Transport\Whatsapp;
use PHPUnit\Framework\TestCase;

class WhatsappTest extends TestCase
{
    public function testGetName()
    {
        $transport = new Whatsapp();
        $this->assertEquals('whatsapp', $transport->getName());
    }
}