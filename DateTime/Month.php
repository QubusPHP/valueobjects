<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020
 * @author     Joshua Parker <joshua@joshuaparker.dev>
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\ValueObjects\Enum\Enum;

use function strtoupper;

/**
 * @method static string JANUARY()
 * @method static string FEBRUARY()
 * @method static string MARCH()
 * @method static string APRIL()
 * @method static string MAY()
 * @method static string JUNE()
 * @method static string JULY()
 * @method static string AUGUST()
 * @method static string SEPTEMBER()
 * @method static string OCTOBER()
 * @method static string NOVEMBER()
 * @method static string DECEMBER()
 */
class Month extends Enum
{
    public const JANUARY = 'January';
    public const FEBRUARY = 'February';
    public const MARCH = 'March';
    public const APRIL = 'April';
    public const MAY = 'May';
    public const JUNE = 'June';
    public const JULY = 'July';
    public const AUGUST = 'August';
    public const SEPTEMBER = 'September';
    public const OCTOBER = 'October';
    public const NOVEMBER = 'November';
    public const DECEMBER = 'December';

    /**
     * Get current Month.
     */
    public static function now(): Month
    {
        $now = new CarbonImmutable('now');

        return static::fromNativeCarbonImmutable($now);
    }

    /**
     * Returns Month from a native PHP \DateTime.
     *
     * @param CarbonImmutable $date
     * @return Month
     */
    public static function fromNativeCarbonImmutable(CarbonImmutable $date): Month
    {
        $month = strtoupper($date->format('F'));

        return static::byName($month);
    }

    /**
     * Returns a numeric representation of the Month.
     * 1 for January to 12 for December.
     */
    public function getNumericValue(): int
    {
        return $this->getOrdinal() + 1;
    }
}
