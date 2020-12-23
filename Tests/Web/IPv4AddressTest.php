<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\IPv4Address;

class IPv4AddressTest extends TestCase
{
    public function testValidIPv4Address()
    {
        $ip = new IPv4Address('127.0.0.1');

        $this->assertInstanceOf(IPv4Address::class, $ip);
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidIPv4Address()
    {
        new IPv4Address('::1');
    }
}
