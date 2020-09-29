<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\ValueObjects\Number\Natural;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\ValueObjectInterface;

/**
 * Class Minute.
 */
class Minute extends Natural
{
    const MIN_MINUTE = 0;

    const MAX_MINUTE = 59;

    /**
     * Returns a new Minute object.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => ['min_range' => self::MIN_MINUTE, 'max_range' => self::MAX_MINUTE],
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
     * Returns a new Minute from native int value.
     *
     * @param ...int $value
     *
     * @return Minute|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns the current minute.
     *
     * @return Minute
     */
    public static function now(): Minute
    {
        $now = new CarbonImmutable('now');
        $minute = intval($now->format('i'));

        return new static($minute);
    }
}
