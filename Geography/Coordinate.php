<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Geography;

use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\Number\Real;
use League\Geotools\Convert\Convert;
use League\Geotools\Distance\Distance;
use Qubus\ValueObjects\Geography\Latitude;
use Qubus\ValueObjects\Geography\Ellipsoid;
use Qubus\ValueObjects\Geography\Longitude;
use Qubus\ValueObjects\ValueObjectInterface;
use Qubus\ValueObjects\Geography\DistanceUnit;
use Qubus\ValueObjects\Geography\DistanceFormula;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use League\Geotools\Coordinate\Ellipsoid as BaseEllipsoid;
use League\Geotools\Coordinate\Coordinate as BaseCoordinate;

class Coordinate implements ValueObjectInterface
{
    /**
     * @var Latitude
     */
    protected Latitude $latitude;

    /**
     * @var Longitude
     */
    protected Longitude $longitude;

    /**
     * @var Ellipsoid
     */
    protected Ellipsoid $ellipsoid;

    /**
     * Returns a new Coordinate object.
     *
     * @param Latitude       $latitude
     * @param Longitude      $longitude
     * @param Ellipsoid|null $ellipsoid
     */
    public function __construct(Latitude $latitude, Longitude $longitude, Ellipsoid $ellipsoid = null)
    {
        if (null === $ellipsoid) {
            $ellipsoid = Ellipsoid::WGS84();
        }

        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->ellipsoid = $ellipsoid;
    }

    /**
     * Returns a native string version of the Coordiantes object in format "$latitude,$longitude".
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%F,%F', $this->getLatitude()->toNative(), $this->getLongitude()->toNative());
    }

    /**
     * Returns a new Coordinate object from native PHP arguments.
     *
     * @throws \BadMethodCallException
     *
     * @return Coordinate|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        if (count($args) < 2 || count($args) > 3) {
            throw new \BadMethodCallException(
                'You must provide 2 to 3 arguments: 1) latitude, 2) longitude, 3) valid ellipsoid type (optional)'
            );
        }

        $coordinate = new BaseCoordinate([$args[0], $args[1]]);
        $latitude = Latitude::fromNative($coordinate->getLatitude());
        $longitude = Longitude::fromNative($coordinate->getLongitude());

        $nativeEllipsoid = isset($args[2]) ? $args[2] : null;
        $ellipsoid = Ellipsoid::fromNative($nativeEllipsoid);

        return new static($latitude, $longitude, $ellipsoid);
    }

    /**
     * Tells whether tow Coordinate objects are equal.
     *
     * @param Coordinate|ValueObjectInterface $coordinate
     *
     * @return bool
     */
    public function equals(ValueObjectInterface $coordinate): bool
    {
        if (false === Util::classEquals($this, $coordinate)) {
            return false;
        }

        return $this->getLatitude()->equals($coordinate->getLatitude()) &&
            $this->getLongitude()->equals($coordinate->getLongitude()) &&
            $this->getEllipsoid()->equals($coordinate->getEllipsoid());
    }

    /**
     * Returns latitude.
     *
     * @return Latitude
     */
    public function getLatitude(): Latitude
    {
        return clone $this->latitude;
    }

    /**
     * Returns longitude.
     *
     * @return Longitude
     */
    public function getLongitude(): Longitude
    {
        return clone $this->longitude;
    }

    /**
     * Returns ellipsoid.
     *
     * @return Ellipsoid
     */
    public function getEllipsoid(): Ellipsoid
    {
        return $this->ellipsoid;
    }

    /**
     * Returns a degrees/minutes/seconds representation of the coordinate.
     *
     * @return StringLiteral
     */
    public function toDegreesMinutesSeconds(): StringLiteral
    {
        $coordinate = static::getBaseCoordinate($this);
        $convert = new Convert($coordinate);
        $dms = $convert->toDegreesMinutesSeconds();

        return new StringLiteral($dms);
    }

    /**
     * Returns a decimal minutes representation of the coordinate.
     *
     * @return StringLiteral
     */
    public function toDecimalMinutes(): StringLiteral
    {
        $coordinate = static::getBaseCoordinate($this);
        $convert = new Convert($coordinate);
        $dm = $convert->toDecimalMinutes();

        return new StringLiteral($dm);
    }

    /**
     * Returns a Universal Transverse Mercator projection representation of the coordinate in meters.
     *
     * @return StringLiteral
     */
    public function toUniversalTransverseMercator(): StringLiteral
    {
        $coordinate = static::getBaseCoordinate($this);
        $convert = new Convert($coordinate);
        $utm = $convert->toUniversalTransverseMercator();

        return new StringLiteral($utm);
    }

    /**
     * Calculates the distance between two Coordinate objects.
     *
     * @param Coordinate           $coordinate
     * @param DistanceUnit|null    $unit
     * @param DistanceFormula|null $formula
     *
     * @return float
     */
    public function distanceFrom(
        Coordinate $coordinate,
        DistanceUnit $unit = null,
        DistanceFormula $formula = null
    ): Real {
        if (null === $unit) {
            $unit = DistanceUnit::METER();
        }

        if (null === $formula) {
            $formula = DistanceFormula::FLAT();
        }

        $baseThis = static::getBaseCoordinate($this);
        $baseCoordinate = static::getBaseCoordinate($coordinate);

        $distance = new Distance();
        $distance
            ->setFrom($baseThis)
            ->setTo($baseCoordinate)
            ->in($unit->toNative());

        $value = call_user_func([$distance, $formula->toNative()]);

        return new Real($value);
    }

    /**
     * Returns the underlying Coordinate object.
     *
     * @param Coordinate|ValueObjectInterface $coordinate
     *
     * @return BaseCoordinate
     */
    protected static function getBaseCoordinate(ValueObjectInterface $coordinate): BaseCoordinate
    {
        $latitude = $coordinate->getLatitude()->toNative();
        $longitude = $coordinate->getLongitude()->toNative();
        $ellipsoid = BaseEllipsoid::createFromName($coordinate->getEllipsoid()->toNative());

        return new BaseCoordinate([$latitude, $longitude], $ellipsoid);
    }
}
