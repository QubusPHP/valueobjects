<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\ValueObjects\Number\Natural;
use Qubus\Exception\Data\TypeException;

/**
 * Class MonthDay.
 */
class MonthDay extends Natural
{
    const MIN_MONTH_DAY = 1;
    const MAX_MONTH_DAY = 31;

    /**
     * Returns a new MonthDay.
     *
     * @param int $value
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
     *
     * @return MonthDay
     */
    public static function now(): MonthDay
    {
        $now = new CarbonImmutable('now');
        $monthDay = intval($now->format('j'));

        return new static($monthDay);
    }
}
