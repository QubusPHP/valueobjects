<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\IPv6Address;

class IPv6AddressTest extends TestCase
{
    public function testValidIPv6Address()
    {
        $ip = new IPv6Address('::1');

        $this->assertInstanceOf('Qubus\ValueObjects\Web\IPv6Address', $ip);
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */

    public function testInvalidIPv6Address()
    {
        new IPv6Address('127.0.0.1');
    }
}
