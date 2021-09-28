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
use Qubus\ValueObjects\Geography\Latitude;
use Qubus\ValueObjects\Geography\Longitude;
use Qubus\ValueObjects\Number\IntegerNumber;
use Qubus\ValueObjects\Number\RealNumber;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function call_user_func;
use function count;
use function func_get_args;
use function sprintf;

class Coordinate implements ValueObject
{
    /** @var Latitude $latitude */
    protected $latitude;

    /** @var Longitude $longitude */
    protected $longitude;

    /**
     * Returns a new Coordinate object.
     */
    public function __construct(Latitude $latitude, Longitude $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Returns a native string version of the Coordiantes object in format "$latitude,$longitude".
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

        if (count($args) < 2) {
            throw new BadMethodCallException(
                'You must provide 2 arguments: 1) latitude, 2) longitude.'
            );
        }

        return new static($args[0], $args[1]);
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
        $this->getLongitude()->equals($coordinate->getLongitude());
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

    public function round(IntegerNumber $numberOfDecimals)
    {
        $latitude  = round($this->latitude, $numberOfDecimals->toNative());
        $longitude = round($this->longitude, $numberOfDecimals->toNative());
        return new Coordinate($latitude, $longitude);
    }
}
