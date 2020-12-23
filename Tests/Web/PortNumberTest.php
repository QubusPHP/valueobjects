<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\PortNumber;
use Qubus\ValueObjects\Web\UrlPortNumber;

class PortNumberTest extends TestCase
{
    public function testValidPortNumber()
    {
        $port = new UrlPortNumber(80);

        $this->assertInstanceOf(PortNumber::class, $port);
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidPortNumber()
    {
        new UrlPortNumber(65536);
    }
}
