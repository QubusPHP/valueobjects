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

namespace Qubus\ValueObjects\Climate;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\Natural;
use Qubus\ValueObjects\ValueObject;

use function filter_var;
use function func_get_arg;
use function sprintf;

use const FILTER_VALIDATE_INT;

class RelativeHumidity extends Natural
{
    public const MIN = 0;

    public const MAX = 100;

    /**
     * Returns a new RelativeHumidity object.
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
     * @param int ...$value
     * @return RelativeHumidity|ValueObject
     */
    public static function fromNative(): ValueObject
    {
        $value = func_get_arg(0);

        return new static($value);
    }
}
