<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Geography;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Geography\Longitude;

class LongitudeTest extends TestCase
{
    public function testValidLongitude()
    {
        Assert::assertInstanceOf(Longitude::class, new Longitude(16.555838));
    }

    public function testNormalization()
    {
        $longitude = new Longitude(-179);
        Assert::assertEquals(-179, $longitude->toNative());
    }

    public function testInvalidLongitude()
    {
        $this->expectException(TypeException::class);

        new Longitude('invalid');
    }
}
