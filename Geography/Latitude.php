<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Geography;

use League\Geotools\Coordinate\Coordinate as BaseCoordinate;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\Real;

class Latitude extends Real
{
    /**
     * Returns a new Latitude object.
     *
     * @throws TypeException
     */
    public function __construct(float $value)
    {
        // normalization process through Coordinate object
        $coordinate = new BaseCoordinate([$value, 0]);
        $latitude = $coordinate->getLatitude();

        $this->value = $latitude;
    }
}
