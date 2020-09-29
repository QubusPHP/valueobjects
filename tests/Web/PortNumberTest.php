<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\PortNumber;

class PortNumberTest extends TestCase
{
    public function testValidPortNumber()
    {
        $port = new PortNumber(80);

        $this->assertInstanceOf('Qubus\ValueObjects\Web\PortNumber', $port);
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidPortNumber()
    {
        new PortNumber(65536);
    }
}
