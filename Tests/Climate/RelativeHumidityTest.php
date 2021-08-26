<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Climate;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Climate\RelativeHumidity;

class RelativeHumidityTest extends TestCase
{
    public function testFromNative()
    {
        $fromNativeRelHum  = RelativeHumidity::fromNative(70);
        $constructedRelHum = new RelativeHumidity(70);

        Assert::assertTrue($fromNativeRelHum->equals($constructedRelHum));
    }

    public function testInvalidRelativeHumidity()
    {
        $this->expectException(TypeException::class);

        new RelativeHumidity(128);
    }
}
