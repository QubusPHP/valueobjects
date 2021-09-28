<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Web\IPAddress;
use Qubus\ValueObjects\Web\IPAddressVersion;

class IPAddressTest extends TestCase
{
    public function testGetVersion()
    {
        $ip4 = new IPAddress('127.0.0.1');
        Assert::assertSame(IPAddressVersion::IPV4(), $ip4->getVersion());

        $ip6 = new IPAddress('::1');
        Assert::assertSame(IPAddressVersion::IPV6(), $ip6->getVersion());
    }

    public function testInvalidIPAddress()
    {
        $this->expectException(TypeException::class);

        new IPAddress('invalid');
    }
}
