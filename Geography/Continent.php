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

/**
 * @method static string AFRICA()
 * @method static string EUROPE()
 * @method static string ASIA()
 * @method static string NORTH_AMERICA()
 * @method static string SOUTH_AMERICA()
 * @method static string ANTARCTICA()
 * @method static string AUSTRALIA()
 */
class Continent extends Enum
{
    public const AFRICA = 'Africa';
    public const EUROPE = 'Europe';
    public const ASIA = 'Asia';
    public const NORTH_AMERICA = 'North America';
    public const SOUTH_AMERICA = 'South America';
    public const ANTARCTICA = 'Antarctica';
    public const AUSTRALIA = 'Australia';
}
