<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Climate;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Climate\RelativeHumidity;

class RelativeHumidityTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeRelHum  = RelativeHumidity::fromNative(70);
        $constructedRelHum = new RelativeHumidity(70);

        $this->assertTrue($fromNativeRelHum->equals($constructedRelHum));
    }

    /**
     * @expectedException \Qubus\Exception\Data\TypeException
     */
    public function testInvalidRelativeHumidity()
    {
        new RelativeHumidity(128);
    }
}
