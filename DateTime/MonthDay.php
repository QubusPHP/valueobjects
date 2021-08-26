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

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\Natural;

use function filter_var;
use function intval;
use function sprintf;

use const FILTER_VALIDATE_INT;

class MonthDay extends Natural
{
    public const MIN_MONTH_DAY = 1;
    public const MAX_MONTH_DAY = 31;

    /**
     * Returns a new MonthDay.
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => ['min_range' => self::MIN_MONTH_DAY, 'max_range' => self::MAX_MONTH_DAY],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter an integer between 0 and 31.',
                    $value
                )
            );
        }

        parent::__construct($value);
    }

    /**
     * Returns the current month day.
     */
    public static function now(): MonthDay
    {
        $now = new CarbonImmutable('now');
        $monthDay = intval($now->format('j'));

        return new static($monthDay);
    }
}
