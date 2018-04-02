<?php

namespace App\Tests\Message\Transport;

use App\Message\Transport\Viber;
use PHPUnit\Framework\TestCase;

class ViberTest extends TestCase
{
    public function testGetName()
    {
        $transport = new Viber();
        $this->assertEquals('viber', $transport->getName());
    }
}