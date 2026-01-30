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
 * @method static string FOOT()
 * @method static string METER()
 * @method static string KILOMETER()
 * @method static string MILE()
 */
class DistanceUnit extends Enum
{
    public const string FOOT = 'ft';
    public const string METER = 'mt';
    public const string KILOMETER = 'km';
    public const string MILE = 'mi';
}
