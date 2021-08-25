<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\Domain;
use Qubus\ValueObjects\Web\Hostname;
use Qubus\ValueObjects\Web\IPAddress;

final class DomainTest extends TestCase
{
    public function testSpecifyType()
    {
        $ip       = Domain::specifyType('127.0.0.1');
        $hostname = Domain::specifyType('example.com');

        Assert::assertInstanceOf(IPAddress::class, $ip);
        Assert::assertInstanceOf(Hostname::class, $hostname);
    }
}
