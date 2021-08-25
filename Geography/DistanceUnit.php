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
 * @method static string FOOT()
 * @method static string METER()
 * @method static string KILOMETER()
 * @method static string MILE()
 */
class DistanceUnit extends Enum
{
    public const FOOT = 'ft';
    public const METER = 'mt';
    public const KILOMETER = 'km';
    public const MILE = 'mi';
}
