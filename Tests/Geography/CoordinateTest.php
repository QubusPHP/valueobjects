<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Geography;

use BadMethodCallException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Geography\Coordinate;
use Qubus\ValueObjects\Geography\Ellipsoid;
use Qubus\ValueObjects\Geography\Latitude;
use Qubus\ValueObjects\Geography\Longitude;
use Qubus\ValueObjects\Number\IntegerNumber;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
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
            new Longitude(16.555838),
        );
    }

    public function testNullConstructorEllipsoid()
    {
        $this->assertTrue($this->coordinate->getEllipsoid()->equals(Ellipsoid::WGS84()));
    }

    /*public function testFromNative()
    {
        $fromNativeCoordinate = Coordinate::fromNative(40.829137, 16.555838, 'WGS84');
        Assert::assertTrue($this->coordinate->equals($fromNativeCoordinate));
    }*/

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
            new Longitude(16.555839),
            Ellipsoid::WGS60()
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

    public function getEllipsoid()
    {
        $ellipsoid = Ellipsoid::WGS84();
        Assert::assertTrue($this->coordinate->getEllipsoid()->equals($ellipsoid));
    }

    public function testToDegreesMinutesSeconds()
    {
        $dms = new StringLiteral('40°49′45″N, 16°33′21″E');
        Assert::assertTrue($this->coordinate->toDegreesMinutesSeconds()->equals($dms));
    }

    public function testToDecimalMinutes()
    {
        $dm = new StringLiteral('40 49.74822N, 16 33.35028E');
        Assert::assertTrue($this->coordinate->toDecimalMinutes()->equals($dm));
    }

    /*public function testToUniversalTransverseMercator()
    {
        $utm = new StringLiteral('33T 631188 4520953');
        Assert::assertTrue($this->coordinate->toUniversalTransverseMercator()->equals($utm));
    }*/

    /*public function testDistanceFrom()
    {
        $newYork = new Coordinate(
            new Latitude(41.145556),
            new Longitude(- 73.995)
        );

        $distance = $this->coordinate->distanceFrom($newYork);
        Assert::assertSame(
            round(7609069.61555, 5),
            round($distance->toNative(), 5)
        );
    }*/

    public function testToString()
    {
        Assert::assertSame('40.829137,16.555838', $this->coordinate->__toString());
    }

    public function testDifferentLocaleWithDifferentDecimalCharacter()
    {
        setlocale(LC_ALL, "de_DE.UTF-8");

        $this->testNullConstructorEllipsoid();
        //$this->testFromNative();
        $this->testSameValueAs();
        $this->getLatitude();
        $this->getLongitude();
        $this->getEllipsoid();
        //$this->testToUniversalTransverseMercator();
        //$this->testDistanceFrom();
        $this->testToString();
    }
}
