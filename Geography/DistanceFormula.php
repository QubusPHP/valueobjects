<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Geography;

use Qubus\ValueObjects\Enum\Enum;

/**
 * @method static string FLAT()
 * @method static string HAVERSINE()
 * @method static string VINCENTY()
 */
class DistanceFormula extends Enum
{
    const FLAT = 'flat';
    const HAVERSINE = 'haversine';
    const VINCENTY = 'vincenty';
}
