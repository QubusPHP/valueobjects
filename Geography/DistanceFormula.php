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

use Qubus\ValueObjects\Enum\Enum;

/**
 * @method static string FLAT()
 * @method static string HAVERSINE()
 * @method static string VINCENTY()
 */
class DistanceFormula extends Enum
{
    public const FLAT = 'flat';
    public const HAVERSINE = 'haversine';
    public const VINCENTY = 'vincenty';
}
