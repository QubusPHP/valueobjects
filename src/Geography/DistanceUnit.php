<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Geography;

use Qubus\ValueObjects\Enum\Enum;

/**
 * @method static string FOOT()
 * @method static string METER()
 * @method static string KILOMETER()
 * @method static string MILE()
 */
class DistanceUnit extends Enum
{
    const FOOT = 'ft';
    const METER = 'mt';
    const KILOMETER = 'km';
    const MILE = 'mi';
}
