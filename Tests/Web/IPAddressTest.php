<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\IPAddress;
use Qubus\ValueObjects\Web\IPAddressVersion;

class IPAddressTest extends TestCase
{
    public function testGetVersion()
    {
        $ip4 = new IPAddress('127.0.0.1');
        $this->assertSame(IPAddressVersion::IPV4(), $ip4->getVersion());

        $ip6 = new IPAddress('::1');
        $this->assertSame(IPAddressVersion::IPV6(), $ip6->getVersion());
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidIPAddress()
    {
        new IPAddress('invalid');
    }
}
