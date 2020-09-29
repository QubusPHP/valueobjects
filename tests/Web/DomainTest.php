<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\Domain;

final class DomainTest extends TestCase
{
    public function testSpecifyType()
    {
        $ip       = Domain::specifyType('127.0.0.1');
        $hostname = Domain::specifyType('example.com');

        $this->assertInstanceOf('Qubus\ValueObjects\Web\IPAddress', $ip);
        $this->assertInstanceOf('Qubus\ValueObjects\Web\Hostname', $hostname);
    }
}
