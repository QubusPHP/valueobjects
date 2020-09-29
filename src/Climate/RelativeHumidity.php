<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Climate;

use Qubus\ValueObjects\Number\Natural;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\ValueObjectInterface;

class RelativeHumidity extends Natural
{
    const MIN = 0;

    const MAX = 100;

    /**
     * Returns a new RelativeHumidity object.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => ['min_range' => self::MIN, 'max_range' => self::MAX],
        ];
        $value = filter_var($value, FILTER_VALIDATE_INT, $options);
        if (false === $value) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must be an integer (>= %s, <= %s).',
                    $value,
                    self::MIN,
                    self::MAX
                )
            );
        }
        parent::__construct($value);
    }

    /**
     * Returns a new RelativeHumidity from native int value.
     *
     * @param ...int $value
     *
     * @return RelativeHumidity|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $value = func_get_arg(0);

        return new static($value);
    }
}
