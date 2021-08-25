<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Number;

use Qubus\ValueObjects\Enum\Enum;

use const PHP_ROUND_HALF_DOWN;
use const PHP_ROUND_HALF_EVEN;
use const PHP_ROUND_HALF_ODD;
use const PHP_ROUND_HALF_UP;

/**
 * @method static int HALF_UP()
 * @method static int HALF_DOWN()
 * @method static int HALF_EVEN()
 * @method static int HALF_ODD()
 */
class RoundingMode extends Enum
{
    public const HALF_UP   = PHP_ROUND_HALF_UP;
    public const HALF_DOWN = PHP_ROUND_HALF_DOWN;
    public const HALF_EVEN = PHP_ROUND_HALF_EVEN;
    public const HALF_ODD  = PHP_ROUND_HALF_ODD;
}
