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

class Longitude extends Real
{
    /**
     * Returns a new Longitude object.
     *
     * @throws TypeException
     */
    public function __construct(float $value)
    {
        // normalization process through Coordinate object
        $coordinate = new BaseCoordinate([0, $value]);
        $longitude = $coordinate->getLongitude();

        $this->value = $longitude;
    }
}
