<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020
 * @author     Joshua Parker <joshua@joshuaparker.dev>
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Geography;

use Qubus\ValueObjects\Enum\Enum;

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
    public const string AFRICA = 'Africa';
    public const string EUROPE = 'Europe';
    public const string ASIA = 'Asia';
    public const string NORTH_AMERICA = 'North America';
    public const string SOUTH_AMERICA = 'South America';
    public const string ANTARCTICA = 'Antarctica';
    public const string AUSTRALIA = 'Australia';
}
