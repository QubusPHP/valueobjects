<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
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

class Second extends Natural
{
    public const MIN_SECOND = 0;
    public const MAX_SECOND = 59;

    /**
     * Returns a new Second object.
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => ['min_range' => self::MIN_SECOND, 'max_range' => self::MAX_SECOND],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter an integer between 0 and 59.',
                    $value
                )
            );
        }

        parent::__construct($value);
    }

    /**
     * Returns the current second.
     */
    public static function now(): Second
    {
        $now = new CarbonImmutable('now');
        $second = intval($now->format('s'));

        return new static($second);
    }
}
