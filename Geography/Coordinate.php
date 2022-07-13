<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020 Joshua Parker
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Geography;

use BadMethodCallException;
use League\Geotools\Convert\Convert;
use League\Geotools\Coordinate\Coordinate as BaseCoordinate;
use League\Geotools\Coordinate\Ellipsoid as BaseEllipsoid;
use League\Geotools\Distance\Distance;
use Qubus\ValueObjects\Geography\Latitude;
use Qubus\ValueObjects\Geography\Longitude;
use Qubus\ValueObjects\Number\IntegerNumber;
use Qubus\ValueObjects\Number\RealNumber;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function count;
use function func_get_args;
use function sprintf;

class Coordinate implements ValueObject
{
    /**
     * Returns a new Coordinate object.
     */
    public function __construct(
        protected Latitude $latitude,
        protected Longitude $longitude,
        protected ?Ellipsoid $ellipsoid = null,
    ) {
        if (null === $ellipsoid) {
            $ellipsoid = Ellipsoid::WGS84();
        }

        $this->ellipsoid = $ellipsoid;
    }

    /**
     * Returns a native string version of the Coordinates object in format "$latitude,$longitude".
     */
    public function __toString(): string
    {
        return sprintf('%F,%F', $this->getLatitude()->toNative(), $this->getLongitude()->toNative());
    }

    /**
     * Returns a new Coordinate object from native PHP arguments.
     *
     * @throws BadMethodCallException
     * @return Coordinate|ValueObject
     */
    public static function fromNative(): ValueObject
    {
        $args = func_get_args();

        if (count($args) < 2 | count($args) > 3) {
            throw new BadMethodCallException(
                'You must provide 2 to 3 arguments: 1) latitude, 2) longitude, 3) valid ellipsoid type (optional).'
            );
        }

        $coordinate = new BaseCoordinate([$args[0], $args[1]]);
        $latitude = Latitude::fromNative($coordinate->getLatitude());
        $longitude = Longitude::fromNative($coordinate->getLongitude());

        $nativeEllipsoid = $args[2] ?? null;
        $ellipsoid = Ellipsoid::fromNative($nativeEllipsoid);

        return new self($latitude, $longitude, $ellipsoid);
    }

    /**
     * Tells whether tow Coordinate objects are equal.
     *
     * @param Coordinate|ValueObject $coordinate
     */
    public function equals(ValueObject $coordinate): bool
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
     */
    public function getLatitude(): Latitude
    {
        return clone $this->latitude;
    }

    /**
     * Returns longitude.
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
    ): RealNumber {
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

        return new RealNumber($value);
    }

    /**
     * Returns the underlying Coordinate object.
     *
     * @param Coordinate|ValueObject $coordinate
     *
     * @return BaseCoordinate
     */
    protected static function getBaseCoordinate(ValueObject $coordinate): BaseCoordinate
    {
        $latitude = $coordinate->getLatitude()->toNative();
        $longitude = $coordinate->getLongitude()->toNative();
        $ellipsoid = BaseEllipsoid::createFromName($coordinate->getEllipsoid()->toNative());

        return new BaseCoordinate([$latitude, $longitude], $ellipsoid);
    }
}
