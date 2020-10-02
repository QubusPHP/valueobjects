<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Geography;

use Qubus\ValueObjects\Number\Real;
use Qubus\Exception\Data\TypeException;
use League\Geotools\Coordinate\Coordinate as BaseCoordinate;

class Longitude extends Real
{
    /**
     * Returns a new Longitude object.
     *
     * @param float $value
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
