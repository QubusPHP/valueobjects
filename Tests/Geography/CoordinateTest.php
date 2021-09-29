<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Geography;

use BadMethodCallException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Geography\Coordinate;
use Qubus\ValueObjects\Geography\Latitude;
use Qubus\ValueObjects\Geography\Longitude;
use Qubus\ValueObjects\ValueObject;

use function setlocale;

use const LC_ALL;

class CoordinateTest extends TestCase
{
    /** @var Coordinate */
    protected $coordinate;

    public function setup(): void
    {
        // When tests run in a different locale, this might affect the decimal-point character and thus the validation
        // of floats. This makes sure the tests run in a locale that the tests are known to be working in.
        setlocale(LC_ALL, "en_US.UTF-8");

        $this->coordinate = new Coordinate(
            new Latitude(40.829137),
            new Longitude(16.555838)
        );
    }

    public function testFromNative()
    {
        $fromNativeCoordinate = Coordinate::fromNative(new Latitude(40.829137), new Longitude(16.555838));
        Assert::assertTrue($this->coordinate->equals($fromNativeCoordinate));
    }

    public function testInvalidFromNative()
    {
        $this->expectException(BadMethodCallException::class);

        Coordinate::fromNative(40.829137);
    }

    public function testSameValueAs()
    {
        $coordinate2 = new Coordinate(
            new Latitude(40.829137),
            new Longitude(16.555838)
        );
        $coordinate3 = new Coordinate(
            new Latitude(40.829137),
            new Longitude(16.555839)
        );

        Assert::assertTrue($this->coordinate->equals($coordinate2));
        Assert::assertTrue($coordinate2->equals($this->coordinate));
        Assert::assertFalse($this->coordinate->equals($coordinate3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($this->coordinate->equals($mock));
    }

    public function getLatitude()
    {
        $latitude = new Latitude(40.829137);
        Assert::assertTrue($this->coordinate->getLatitude()->equals($latitude));
    }

    public function getLongitude()
    {
        $longitude = new Longitude(16.555838);
        Assert::assertTrue($this->coordinate->getLongitude()->equals($longitude));
    }

    public function testToString()
    {
        Assert::assertSame('40.829137,16.555838', $this->coordinate->__toString());
    }

    public function testDifferentLocaleWithDifferentDecimalCharacter()
    {
        setlocale(LC_ALL, "de_DE.UTF-8");

        $this->testFromNative();
        $this->testSameValueAs();
        $this->getLatitude();
        $this->getLongitude();
        $this->testToString();
    }
}
