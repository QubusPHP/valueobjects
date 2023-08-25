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
