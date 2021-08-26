<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Web\PortNumber;
use Qubus\ValueObjects\Web\UrlPortNumber;

class PortNumberTest extends TestCase
{
    public function testValidPortNumber()
    {
        $port = new UrlPortNumber(80);

        Assert::assertInstanceOf(PortNumber::class, $port);
    }

    public function testInvalidPortNumber()
    {
        new UrlPortNumber(65536);

        $this->expectException(TypeException::class);
    }
}
