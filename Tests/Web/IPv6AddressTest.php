<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Web\IPv6Address;

class IPv6AddressTest extends TestCase
{
    public function testValidIPv6Address()
    {
        $ip = new IPv6Address('::1');

        Assert::assertInstanceOf(IPv6Address::class, $ip);
    }

    public function testInvalidIPv6Address()
    {
        new IPv6Address('127.0.0.1');

        $this->expectException(TypeException::class);
    }
}
