<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Geography;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Geography\Latitude;
use TypeError;

class LatitudeTest extends TestCase
{
    public function testValidLatitude()
    {
        Assert::assertInstanceOf(
            Latitude::class,
            new Latitude(40.829137)
        );
    }

    public function testNormalization()
    {
        $latitude = new Latitude(91);
        Assert::assertEquals(90, $latitude->toNative());
    }

    public function testInvalidLatitude()
    {
        $this->expectException(TypeError::class);

        new Latitude('invalid');
    }
}
