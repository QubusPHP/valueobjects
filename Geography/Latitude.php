<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Geography;

use Qubus\ValueObjects\Number\Real;
use Qubus\Exception\Data\TypeException;
use League\Geotools\Coordinate\Coordinate as BaseCoordinate;

class Latitude extends Real
{
    /**
     * Returns a new Latitude object.
     *
     * @param  float $value
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
