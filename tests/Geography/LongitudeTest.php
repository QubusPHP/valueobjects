<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Geography;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Geography\Longitude;

class LongitudeTest extends TestCase
{
    public function testValidLongitude()
    {
        $this->assertInstanceOf(Longitude::class, new Longitude(16.555838));
    }

    public function testNormalization()
    {
        $longitude = new Longitude(181);
        $this->assertEquals(-179, $longitude->toNative());
    }

    /**
     * @expectedException \TypeError
     */
    public function testInvalidLongitude()
    {
        new Longitude('invalid');
    }
}
