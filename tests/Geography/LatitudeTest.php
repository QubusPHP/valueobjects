<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Geography;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Geography\Latitude;

class LatitudeTest extends TestCase
{
    public function testValidLatitude()
    {
        $this->assertInstanceOf(
            Latitude::class,
            new Latitude(40.829137)
        );
    }

    public function testNormalization()
    {
        $latitude = new Latitude(91);
        $this->assertEquals(90, $latitude->toNative());
    }

    /** @expectedException \TypeError */
    public function testInvalidLatitude()
    {
        new Latitude('invalid');
    }
}
