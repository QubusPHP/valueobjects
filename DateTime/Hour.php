<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\ValueObjects\Number\Natural;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\ValueObjectInterface;

/**
 * Class Hour.
 */
class Hour extends Natural
{
    const MIN_HOUR = 0;
    const MAX_HOUR = 23;

    /**
     * Returns a new Hour object.
     *
     * @param  int $value
     * @throws \Qubus\Exception\Data\TypeException
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => ['min_range' => self::MIN_HOUR, 'max_range' => self::MAX_HOUR],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter an integer between 0 and 23.',
                    $value
                )
            );
        }

        parent::__construct($value);
    }

    /**
     * Returns a new Hour from native int value.
     *
     * @param ...int $value
     *
     * @return Hour|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns the current hour.
     *
     * @return Hour
     */
    public static function now(): Hour
    {
        $now = new CarbonImmutable('now');
        $hour = intval($now->format('G'));

        return new static($hour);
    }
}
