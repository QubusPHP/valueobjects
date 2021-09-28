<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Web\IPv4Address;

class IPv4AddressTest extends TestCase
{
    public function testValidIPv4Address()
    {
        $ip = new IPv4Address('127.0.0.1');

        Assert::assertInstanceOf(IPv4Address::class, $ip);
    }

    public function testInvalidIPv4Address()
    {
        $this->expectException(TypeException::class);

        new IPv4Address('::1');
    }
}
